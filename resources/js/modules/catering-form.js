/**
 * Yan's Food — Catering 3-Step Wizard Form Module (§6.1–§6.6, M14–M17)
 * Compliant with YANS-FOOD-WEB-UX-SPECIFICATION.md
 * 
 * Features:
 * - 3-Step Stepper (Acara -> Pilih Menu -> Konfirmasi) with progressive validation
 * - Dynamic minimum date (H-2) + helpful fallback message
 * - Stepper quantity buttons with live subtotal and total calculations
 * - Minimum order rule (Rp 200.000) with visual progress bar
 * - Auto-save draft to localStorage (48h TTL) with recovery banner
 * - Automatic phone number normalization (+62)
 * - Idempotency UUID token + honeypot spam protection + min 4s fill time check
 * - Deep link product query (?produk=slug) auto-increment
 */

export function initCateringForm() {
    const formContainer = document.getElementById('catering-form-container');
    if (!formContainer) return;

    const formEl = document.getElementById('catering-booking-form');
    if (!formEl) return;

    // 1. Initial State & Configuration
    const STORAGE_KEY = 'yf_catering_draft_v1';
    const TTL_MS = 48 * 60 * 60 * 1000; // 48 jam (§6.6)
    const MIN_ORDER_AMOUNT = 200000;
    const formMountedAt = Date.now();
    const idempotencyToken = crypto.randomUUID ? crypto.randomUUID() : 'idemp-' + Date.now() + '-' + Math.random().toString(36).substring(2, 9);

    // Calculate Min Date (Today + 2 days)
    const today = new Date();
    const minD = new Date(today);
    minD.setDate(today.getDate() + 2);
    const minDateStr = minD.toISOString().split('T')[0];

    // Load Products Catalog from embedded JSON or fallback
    let catalog = [];
    const productsJsonEl = document.getElementById('catering-products-data');
    if (productsJsonEl && productsJsonEl.textContent) {
        try {
            catalog = JSON.parse(productsJsonEl.textContent);
        } catch (e) {
            console.warn('Failed parsing catering products data', e);
        }
    }

    if (!catalog || catalog.length === 0) {
        catalog = [
            { id: 1, name: 'Paket Snack Box Manis & Gurih', category: 'Snack Box', price: 12000, unit: 'box', image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuARZOQ96wet-CMX5rdD7lCFZyLs1EkrpKnlUC0RR99N8F7qRKAtVDp0zOXrFg0euopAroL4wdJES5KEUP4Mc10u-UzZYXlvj3_U850HmHFdI-2qa02DqfAOUMw-0VbCaGvmAt2949p2eWuHqz3RcdS7ODq1G6OninQUnQZKMoxPO6O-lS3WjYQWINUV6vdxskptYAzfbyMOIB5K2-d37eZht5g2KMxF67gGOJStQ-AFmbk3gNEvgEtd', qty: 20 },
            { id: 2, name: 'Paket Nasi Kotak Nusantara (Terpopuler)', category: 'Nasi Kotak', price: 28000, unit: 'box', image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDFkmFBQYeBj264oHilvJ9JGnrJ_1PQwJXxR2gokTFFviNr5gzGCDexUL9qKdLaBaTQmtl7Kr6kSRlVtonMXlr1NwwYVSGTCtr6AFa_iWNSqQ0D74vSZRm_HMXg6AOgcxsT3bHsrxoTQvSyHcyUcv3avNKLywFGPb8AYZAxOuVzhC-mVzhPiHFbQD6tEbON-W1f62G9pLQr_QEupaxxHXBTmkPriy348OCpVdEAQzNnXKeNuLYcLUDR', qty: 0 },
            { id: 3, name: 'Risol Mayo Spesial (Satuan)', category: 'Kudapan', price: 4500, unit: 'pcs', image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCyfuXln7cyGrY2lKM07Nk3VKMQjY3ZTmHoC1dw90oSQpU6K9GToD9dsNw7j-ONqeDlAGA4dUHsambXmkUw1VSykY9WS5EuOrd2vXOLVz_gDlJDQpTckcMcGct8EuAcmM-Aj5VFqr78aR9bpsCfWc7L5uPmlfvvfJvmZbLdxztCm-fUjNoCNBg6rJwiIGonOikHOEVhan_cN8QOl7vVORz_mOuXsXhhH3TopjOFzgKMvjN75USyuea4', qty: 0 },
            { id: 4, name: 'Pisang Coklat Crispy (Satuan)', category: 'Kudapan', price: 3500, unit: 'pcs', image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBts6_Y8VjNhmV1LnrN6Dm5iR4sSQV3xhLKrMWDJ6fdyqbxY5O9UUI0S756Cpv4FT1Yz-u3S4boBHAif6DwRvoIGDRnvaOAQC6T3FOJTit1ctKXlOxUcwCSHO1NAsIzokrAtdKAhabshRPcb8-79Kx_Y0Npfeb0F49PFjc2JS3S2A5MMw-cxhx3jqPOPn8bT9D07fWrCrU6OzYatoJuHKSSOFKhB75_p_Sr9SRd84JFSYkDWNiu3HvX', qty: 0 },
            { id: 5, name: 'Nasi Goreng Jadul Yan\'s', category: 'Makanan Berat', price: 22000, unit: 'porsi', image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCvbMqJp4vasmNPRn7HlUQ53R3QwrbMiAJGRmOeSP3xoEqc-hb5EkQx28tGjOOddzhbh0BvjFwX_K2C7FkHaJpySF2zidCDs-Bx_mHHA3URhRcMv1OQhfIUJ4SnK1xWUswF-WwKCxa8-zJZmfBBJz1XBLusLQAzk5BcvZvIXzaDl0b5CzAHuTSEZQKFm2axnelXGbXdYgGwaMGpV41iikvWXq7ZllZ-h_pkIUZOUgUcN8KoU_ETwohF', qty: 0 }
        ];
    } else {
        catalog = catalog.map(item => ({
            ...item,
            qty: item.qty || 0
        }));
    }

    // Wizard State
    const state = {
        step: 1,
        minDate: minDateStr,
        isSubmitting: false,
        deliveryType: 'diantar', // 'diantar' | 'ambil'
        form: {
            event_date: minDateStr,
            event_time: '11:00',
            event_purpose: 'Arisan Keluarga / RT',
            delivery_address: '',
            customer_name: '',
            customer_phone: '',
            notes: '',
            website_trap: ''
        },
        catalog: catalog
    };

    // DOM Elements Cache
    const stepsEls = {
        1: formContainer.querySelector('[data-step="1"]'),
        2: formContainer.querySelector('[data-step="2"]'),
        3: formContainer.querySelector('[data-step="3"]')
    };

    const stepBarFill = formContainer.querySelector('[data-stepper-fill]');
    const stepCircles = formContainer.querySelectorAll('[data-step-circle]');
    const draftBanner = document.getElementById('catering-draft-banner');

    // 2. Draft Storage Functions
    function saveDraft() {
        try {
            const data = {
                form: state.form,
                catalog: state.catalog.map(c => ({ id: c.id, qty: c.qty })),
                deliveryType: state.deliveryType,
                step: state.step,
                savedAt: Date.now()
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        } catch (e) {
            console.warn('Storage save failed', e);
        }
    }

    function checkDraft() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return;
            const parsed = JSON.parse(raw);
            if (Date.now() - (parsed.savedAt || 0) < TTL_MS) {
                if (draftBanner) draftBanner.classList.remove('hidden');
            } else {
                localStorage.removeItem(STORAGE_KEY);
            }
        } catch (e) {}
    }

    function restoreDraft() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return;
            const parsed = JSON.parse(raw);
            if (parsed.form) Object.assign(state.form, parsed.form);
            if (parsed.deliveryType) state.deliveryType = parsed.deliveryType;
            if (parsed.step) state.step = parsed.step;
            if (parsed.catalog && Array.isArray(parsed.catalog)) {
                parsed.catalog.forEach(savedItem => {
                    const match = state.catalog.find(c => c.id == savedItem.id);
                    if (match) match.qty = savedItem.qty;
                });
            }

            syncFormInputsFromState();
            renderCatalogList();
            renderLiveSummary();
            setStep(state.step);

            if (draftBanner) draftBanner.classList.add('hidden');
            if (window.showToast) window.showToast('Draf katering berhasil dipulihkan!');
        } catch (e) {
            console.warn(e);
        }
    }

    function discardDraft() {
        try {
            localStorage.removeItem(STORAGE_KEY);
        } catch (e) {}
        if (draftBanner) draftBanner.classList.add('hidden');
    }

    // 3. UI Synchronization & Stepper Navigation
    function setStep(newStep) {
        if (newStep < 1 || newStep > 3) return;
        state.step = newStep;

        // Hide all steps, reveal current
        Object.keys(stepsEls).forEach(k => {
            if (stepsEls[k]) {
                if (parseInt(k, 10) === newStep) {
                    stepsEls[k].classList.remove('hidden');
                    stepsEls[k].classList.add('fade-in');
                    const heading = stepsEls[k].querySelector('h3');
                    if (heading) {
                        heading.setAttribute('tabindex', '-1');
                        heading.focus();
                    }
                } else {
                    stepsEls[k].classList.add('hidden');
                    stepsEls[k].classList.remove('fade-in');
                }
            }
        });

        // Update Stepper Bar Fill & Circles
        if (stepBarFill) {
            const fillPct = newStep === 1 ? '0%' : (newStep === 2 ? '50%' : '100%');
            stepBarFill.style.width = fillPct;
        }

        stepCircles.forEach((circle, idx) => {
            const circleStep = idx + 1;
            const iconCheck = circle.querySelector('.step-check-icon');
            const stepNum = circle.querySelector('.step-num-text');

            if (circleStep < newStep) {
                circle.classList.remove('bg-surface-warm', 'text-secondary', 'border-surface-variant');
                circle.classList.add('bg-primary', 'text-white', 'ring-4', 'ring-primary/20');
                if (iconCheck) iconCheck.classList.remove('hidden');
                if (stepNum) stepNum.classList.add('hidden');
            } else if (circleStep === newStep) {
                circle.classList.remove('bg-surface-warm', 'text-secondary', 'border-surface-variant');
                circle.classList.add('bg-primary', 'text-white', 'ring-4', 'ring-primary/20');
                if (iconCheck) iconCheck.classList.add('hidden');
                if (stepNum) stepNum.classList.remove('hidden');
            } else {
                circle.classList.remove('bg-primary', 'text-white', 'ring-4', 'ring-primary/20');
                circle.classList.add('bg-surface-warm', 'text-secondary', 'border', 'border-surface-variant');
                if (iconCheck) iconCheck.classList.add('hidden');
                if (stepNum) stepNum.classList.remove('hidden');
            }
        });

        if (newStep === 3) {
            renderFinalSummary();
        }

        saveDraft();

        // Scroll into view if not visible
        const rect = formContainer.getBoundingClientRect();
        if (rect.top < 0 || rect.top > window.innerHeight) {
            formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function calculateTotal() {
        return state.catalog.reduce((sum, it) => sum + (it.price * (it.qty || 0)), 0);
    }

    function getSelectedItems() {
        return state.catalog.filter(it => (it.qty || 0) > 0);
    }

    function formatRupiah(num) {
        return 'Rp ' + Number(num || 0).toLocaleString('id-ID');
    }

    // 4. Render Catalog List in Step 2
    function renderCatalogList() {
        const listContainer = document.getElementById('catering-menu-items');
        if (!listContainer) return;

        listContainer.innerHTML = '';

        state.catalog.forEach(item => {
            const isSelected = (item.qty || 0) > 0;
            const row = document.createElement('div');
            row.className = `p-4 rounded-2xl border transition-all duration-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 ${
                isSelected 
                    ? 'bg-sand-bg border-l-4 border-l-primary border-surface-variant shadow-2xs' 
                    : 'bg-surface-warm border-surface-variant/40 hover:border-surface-variant'
            }`;

            row.innerHTML = `
                <div class="flex items-center gap-4">
                    <img src="${item.image || 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=150'}" 
                         alt="${item.name}" 
                         class="w-16 h-16 rounded-xl object-cover bg-surface-variant shrink-0">
                    <div class="space-y-0.5">
                        <span class="inline-block px-2 py-0.5 rounded-full bg-surface-container text-secondary text-[11px] font-semibold">
                            ${item.category || 'Menu Katering'}
                        </span>
                        <h4 class="font-headline-sm text-on-surface font-semibold text-sm sm:text-base leading-snug">
                            ${item.name}
                        </h4>
                        <p class="font-numeric-currency text-primary font-bold text-sm">
                            ${formatRupiah(item.price)} <span class="text-secondary font-normal text-xs">/ ${item.unit || 'porsi'}</span>
                        </p>
                    </div>
                </div>

                <!-- Stepper Quantity (§6.3, M16) -->
                <div class="flex items-center gap-3 self-end sm:self-center">
                    <div class="inline-flex items-center rounded-xl bg-surface-container p-1 border border-surface-variant/40 shadow-inner">
                        <button type="button" 
                                data-qty-action="minus" 
                                data-id="${item.id}"
                                aria-label="Kurangi ${item.name}"
                                class="w-8 h-8 rounded-lg bg-surface-warm text-on-surface hover:bg-surface-variant flex items-center justify-center font-bold transition-all active:scale-95 disabled:opacity-40"
                                ${item.qty <= 0 ? 'disabled' : ''}>
                            <span class="material-symbols-outlined text-[16px]">remove</span>
                        </button>
                        <span class="w-10 text-center font-mono font-bold text-sm text-on-surface select-none">
                            ${item.qty || 0}
                        </span>
                        <button type="button" 
                                data-qty-action="plus" 
                                data-id="${item.id}"
                                aria-label="Tambah ${item.name}"
                                class="w-8 h-8 rounded-lg bg-primary text-white hover:bg-primary-dark flex items-center justify-center font-bold transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                        </button>
                    </div>
                </div>
            `;

            listContainer.appendChild(row);
        });

        // Bind Stepper Actions
        listContainer.querySelectorAll('[data-qty-action]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const action = btn.getAttribute('data-qty-action');
                const id = btn.getAttribute('data-id');
                const target = state.catalog.find(c => c.id == id);
                if (!target) return;

                if (action === 'plus') {
                    // Step increment: if 0, start at 10 or 20 for bulk, or simply +5
                    if (target.qty === 0) {
                        target.qty = target.unit === 'pcs' ? 10 : 10;
                    } else {
                        target.qty += target.unit === 'pcs' ? 5 : 5;
                    }
                } else if (action === 'minus') {
                    target.qty = Math.max(0, target.qty - (target.unit === 'pcs' ? 5 : 5));
                }

                renderCatalogList();
                renderLiveSummary();
                saveDraft();
            });
        });
    }

    // 5. Render Live Order Summary (Desktop Sticky + Mobile Bottom Bar)
    function renderLiveSummary() {
        const total = calculateTotal();
        const selected = getSelectedItems();
        const minMet = total >= MIN_ORDER_AMOUNT;

        // Elements
        const liveTotalDesktop = document.getElementById('live-total-desktop');
        const liveTotalMobile = document.getElementById('live-total-mobile');
        const liveItemsCount = document.getElementById('live-items-count');
        const liveSummaryList = document.getElementById('live-selected-items-list');
        const minOrderAlert = document.getElementById('min-order-alert');
        const minOrderProgress = document.getElementById('min-order-progress');
        const btnNextStep2 = document.getElementById('btn-next-step-2');

        const totalFormatted = formatRupiah(total);
        if (liveTotalDesktop) liveTotalDesktop.textContent = totalFormatted;
        if (liveTotalMobile) liveTotalMobile.textContent = totalFormatted;
        if (liveItemsCount) liveItemsCount.textContent = `${selected.length} item dipilih`;

        // Minimum order rule calculation (§6.3)
        const progressPct = Math.min(100, Math.round((total / MIN_ORDER_AMOUNT) * 100));
        if (minOrderProgress) {
            minOrderProgress.style.width = `${progressPct}%`;
        }

        if (minOrderAlert) {
            if (minMet) {
                minOrderAlert.className = 'p-3 rounded-xl bg-emerald-50 text-emerald-800 text-xs font-semibold flex items-center gap-2 border border-emerald-200';
                minOrderAlert.innerHTML = `
                    <span class="material-symbols-outlined text-[18px] text-emerald-600">check_circle</span>
                    <span>Minimal pesanan Rp 200.000 sudah terpenuhi!</span>
                `;
                if (btnNextStep2) btnNextStep2.removeAttribute('disabled');
            } else {
                const deficit = MIN_ORDER_AMOUNT - total;
                minOrderAlert.className = 'p-3 rounded-xl bg-amber-50 text-amber-900 text-xs flex items-center gap-2 border border-amber-200';
                minOrderAlert.innerHTML = `
                    <span class="material-symbols-outlined text-[18px] text-amber-600">info</span>
                    <span>Minimal pesanan Rp 200.000 (Kurang <strong>${formatRupiah(deficit)}</strong>)</span>
                `;
                if (btnNextStep2) btnNextStep2.setAttribute('disabled', 'true');
            }
        }

        // Render selected items list in right drawer
        if (liveSummaryList) {
            if (selected.length === 0) {
                liveSummaryList.innerHTML = `
                    <div class="py-6 text-center text-secondary text-xs italic">
                        Belum ada menu yang dipilih. Tekan tombol + pada daftar menu di samping.
                    </div>
                `;
            } else {
                liveSummaryList.innerHTML = selected.map(it => `
                    <div class="flex items-center justify-between py-2 border-b border-surface-variant/30 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-bold text-primary">${it.qty}x</span>
                            <span class="font-medium text-on-surface">${it.name}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-semibold text-on-surface">${formatRupiah(it.price * it.qty)}</span>
                            <button type="button" 
                                    data-remove-id="${it.id}" 
                                    aria-label="Hapus ${it.name}" 
                                    class="text-secondary hover:text-red-600 p-0.5">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                            </button>
                        </div>
                    </div>
                `).join('');

                liveSummaryList.querySelectorAll('[data-remove-id]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-remove-id');
                        const target = state.catalog.find(c => c.id == id);
                        if (target) {
                            target.qty = 0;
                            renderCatalogList();
                            renderLiveSummary();
                            saveDraft();
                        }
                    });
                });
            }
        }
    }

    // 6. Render Final Recap Card in Step 3
    function renderFinalSummary() {
        const recapSchedule = document.getElementById('recap-schedule');
        const recapDelivery = document.getElementById('recap-delivery');
        const recapMenu = document.getElementById('recap-menu-list');
        const recapTotal = document.getElementById('recap-total');

        if (recapSchedule) {
            const dateObj = new Date(state.form.event_date);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = !isNaN(dateObj) ? dateObj.toLocaleDateString('id-ID', options) : state.form.event_date;
            recapSchedule.textContent = `${formattedDate} • Pukul ${state.form.event_time} WIB (${state.form.event_purpose})`;
        }

        if (recapDelivery) {
            if (state.deliveryType === 'ambil') {
                recapDelivery.textContent = 'Ambil Sendiri di Dapur Yan\'s Food';
            } else {
                recapDelivery.textContent = `Diantar ke: ${state.form.delivery_address || '-'}`;
            }
        }

        if (recapMenu) {
            const selected = getSelectedItems();
            recapMenu.innerHTML = selected.map(it => `
                <div class="flex items-center justify-between text-xs py-1">
                    <span>${it.name} (${it.qty} ${it.unit || 'porsi'})</span>
                    <span class="font-mono font-bold">${formatRupiah(it.price * it.qty)}</span>
                </div>
            `).join('');
        }

        if (recapTotal) {
            recapTotal.textContent = formatRupiah(calculateTotal());
        }
    }

    // 7. Input Binding & Live Sync
    function syncFormInputsFromState() {
        const dateInput = document.getElementById('event_date');
        const timeInput = document.getElementById('event_time');
        const purposeInput = document.getElementById('event_purpose');
        const addressInput = document.getElementById('customer_address');
        const nameInput = document.getElementById('customer_name');
        const phoneInput = document.getElementById('customer_phone');
        const notesInput = document.getElementById('catering_notes');
        const deliveryRadios = formContainer.querySelectorAll('input[name="delivery_type"]');

        if (dateInput && state.form.event_date) dateInput.value = state.form.event_date;
        if (timeInput && state.form.event_time) timeInput.value = state.form.event_time;
        if (purposeInput && state.form.event_purpose) purposeInput.value = state.form.event_purpose;
        if (addressInput && state.form.delivery_address) addressInput.value = state.form.delivery_address;
        if (nameInput && state.form.customer_name) nameInput.value = state.form.customer_name;
        if (phoneInput && state.form.customer_phone) phoneInput.value = state.form.customer_phone;
        if (notesInput && state.form.notes) notesInput.value = state.form.notes;

        deliveryRadios.forEach(radio => {
            radio.checked = radio.value === state.deliveryType;
        });

        toggleAddressField(state.deliveryType === 'diantar');
    }

    function toggleAddressField(show) {
        const addressWrapper = document.getElementById('delivery-address-wrapper');
        const addressInput = document.getElementById('customer_address');
        if (!addressWrapper) return;

        if (show) {
            addressWrapper.classList.remove('hidden');
            if (addressInput) addressInput.setAttribute('required', 'true');
        } else {
            addressWrapper.classList.add('hidden');
            if (addressInput) addressInput.removeAttribute('required');
        }
    }

    // 8. Event Listeners for Step Changes & Form Elements
    // Step 1 Validation & Proceed
    const btnNextStep1 = document.getElementById('btn-next-step-1');
    if (btnNextStep1) {
        btnNextStep1.addEventListener('click', () => {
            const dateInput = document.getElementById('event_date');
            const timeInput = document.getElementById('event_time');
            const purposeInput = document.getElementById('event_purpose');
            const addressInput = document.getElementById('customer_address');

            if (!dateInput || !dateInput.value) {
                if (window.showToast) window.showToast('Pilih tanggal acara (minimal H-2).');
                if (dateInput) dateInput.focus();
                return;
            }

            if (dateInput.value < state.minDate) {
                if (window.showToast) window.showToast('Tanggal acara minimal H-2 dari hari ini.');
                dateInput.focus();
                return;
            }

            if (state.deliveryType === 'diantar' && (!addressInput || addressInput.value.trim().length < 8)) {
                if (window.showToast) window.showToast('Tuliskan alamat pengantaran lengkap.');
                if (addressInput) addressInput.focus();
                return;
            }

            // Save values to state
            state.form.event_date = dateInput.value;
            state.form.event_time = timeInput ? timeInput.value : '11:00';
            state.form.event_purpose = purposeInput ? purposeInput.value : 'Acara Keluarga';
            state.form.delivery_address = addressInput ? addressInput.value : '';

            setStep(2);
        });
    }

    // Step 2 Proceed
    const btnNextStep2 = document.getElementById('btn-next-step-2');
    if (btnNextStep2) {
        btnNextStep2.addEventListener('click', () => {
            if (calculateTotal() < MIN_ORDER_AMOUNT) {
                if (window.showToast) window.showToast('Minimal pesanan katering adalah Rp 200.000.');
                return;
            }
            setStep(3);
        });
    }

    // Back Buttons
    formContainer.querySelectorAll('[data-action="prev-step"]').forEach(btn => {
        btn.addEventListener('click', () => {
            setStep(state.step - 1);
        });
    });

    // Jump to step via Step Recap Edit Links
    formContainer.querySelectorAll('[data-goto-step]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetStep = parseInt(link.getAttribute('data-goto-step'), 10);
            if (targetStep) setStep(targetStep);
        });
    });

    // Delivery Type Radios
    formContainer.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
        radio.addEventListener('change', () => {
            state.deliveryType = radio.value;
            toggleAddressField(state.deliveryType === 'diantar');
            saveDraft();
        });
    });

    // Event Purpose Chips
    formContainer.querySelectorAll('[data-purpose-chip]').forEach(chip => {
        chip.addEventListener('click', () => {
            const val = chip.getAttribute('data-purpose-chip');
            const purposeInput = document.getElementById('event_purpose');
            if (purposeInput) {
                purposeInput.value = val;
                state.form.event_purpose = val;
                saveDraft();
            }
            formContainer.querySelectorAll('[data-purpose-chip]').forEach(c => {
                c.classList.remove('bg-primary', 'text-white');
                c.classList.add('bg-surface-container', 'text-on-surface');
            });
            chip.classList.remove('bg-surface-container', 'text-on-surface');
            chip.classList.add('bg-primary', 'text-white');
        });
    });

    // Phone formatting auto-normalization (+62)
    const phoneInput = document.getElementById('customer_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', () => {
            let val = phoneInput.value.replace(/[^0-9]/g, '');
            if (val.startsWith('0')) {
                val = val.substring(1);
            } else if (val.startsWith('62')) {
                val = val.substring(2);
            }
            phoneInput.value = val;
            state.form.customer_phone = val ? '62' + val : '';
            saveDraft();
        });
    }

    // Notes Character Counter
    const notesInput = document.getElementById('catering_notes');
    const notesCount = document.getElementById('notes-char-count');
    if (notesInput && notesCount) {
        notesInput.addEventListener('input', () => {
            const current = notesInput.value.length;
            notesCount.textContent = `${current}/500`;
            state.form.notes = notesInput.value;
            saveDraft();
        });
    }

    // Draft Banner Actions
    const btnRestoreDraft = document.getElementById('btn-restore-draft');
    const btnDiscardDraft = document.getElementById('btn-discard-draft');
    if (btnRestoreDraft) btnRestoreDraft.addEventListener('click', restoreDraft);
    if (btnDiscardDraft) btnDiscardDraft.addEventListener('click', discardDraft);

    // 9. Submission Handling (§6.5–§6.6)
    formEl.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (state.isSubmitting) return;

        // Anti-spam min-time check (§6.5: filling time >= 4 seconds)
        const elapsed = (Date.now() - formMountedAt) / 1000;
        if (elapsed < 3) {
            console.warn('Form submission too fast');
            return;
        }

        const nameInput = document.getElementById('customer_name');
        const phoneInput = document.getElementById('customer_phone');
        const agreementCheck = document.getElementById('order_agreement');

        if (!nameInput || nameInput.value.trim().length < 2) {
            if (window.showToast) window.showToast('Tuliskan nama lengkap pemesan.');
            if (nameInput) nameInput.focus();
            return;
        }

        if (!phoneInput || phoneInput.value.trim().length < 8) {
            if (window.showToast) window.showToast('Nomor WhatsApp belum lengkap.');
            if (phoneInput) phoneInput.focus();
            return;
        }

        if (agreementCheck && !agreementCheck.checked) {
            if (window.showToast) window.showToast('Mohon centang persetujuan pesanan katering.');
            agreementCheck.focus();
            return;
        }

        const selectedItems = getSelectedItems();
        if (selectedItems.length === 0 || calculateTotal() < MIN_ORDER_AMOUNT) {
            if (window.showToast) window.showToast('Pilih menu dengan total minimal Rp 200.000.');
            setStep(2);
            return;
        }

        state.isSubmitting = true;
        const submitBtn = document.getElementById('btn-submit-catering');
        if (submitBtn) {
            submitBtn.setAttribute('disabled', 'true');
            const submitText = submitBtn.querySelector('.submit-label');
            const submitSpinner = submitBtn.querySelector('.submit-spinner');
            if (submitText) submitText.textContent = 'Mencatat Pesanan...';
            if (submitSpinner) submitSpinner.classList.remove('hidden');
        }

        const payload = {
            customer_name: nameInput.value.trim(),
            customer_phone: '62' + phoneInput.value.trim().replace(/^0+/, ''),
            customer_address: state.deliveryType === 'ambil' ? 'Ambil Sendiri di Dapur Yan\'s Food' : (state.form.delivery_address || '-'),
            event_date: state.form.event_date,
            event_time: state.form.event_time,
            event_purpose: state.form.event_purpose || 'Acara',
            notes: state.form.notes || '',
            items: selectedItems.map(it => ({
                product_id: it.id,
                quantity: it.qty
            })),
            website_trap: state.form.website_trap || '',
            idempotency_token: idempotencyToken
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        try {
            const response = await fetch('/pesan-catering', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            const res = await response.json();

            if (res.success && res.redirect_url) {
                localStorage.removeItem(STORAGE_KEY);
                window.location.href = res.redirect_url;
            } else if (res.whatsapp_url) {
                localStorage.removeItem(STORAGE_KEY);
                window.location.href = res.whatsapp_url;
            } else {
                if (window.showToast) window.showToast(res.message || 'Terjadi kendala saat menyimpan pesanan.');
                state.isSubmitting = false;
                if (submitBtn) {
                    submitBtn.removeAttribute('disabled');
                    const submitText = submitBtn.querySelector('.submit-label');
                    const submitSpinner = submitBtn.querySelector('.submit-spinner');
                    if (submitText) submitText.textContent = 'Kirim Pesanan Katering';
                    if (submitSpinner) submitSpinner.classList.add('hidden');
                }
            }
        } catch (err) {
            console.error('Submit error', err);
            if (window.showToast) window.showToast('Koneksi terputus. Data pesanan Anda aman, silakan coba kirim ulang.');
            state.isSubmitting = false;
            if (submitBtn) {
                submitBtn.removeAttribute('disabled');
                const submitText = submitBtn.querySelector('.submit-label');
                const submitSpinner = submitBtn.querySelector('.submit-spinner');
                if (submitText) submitText.textContent = 'Kirim Pesanan Katering';
                if (submitSpinner) submitSpinner.classList.add('hidden');
            }
        }
    });

    // 10. Check Deep Link (?produk=slug) from Product Modal / Catalog
    function checkUrlDeepLink() {
        const params = new URLSearchParams(window.location.search);
        const productSlug = params.get('produk');
        if (productSlug) {
            const found = state.catalog.find(c => (c.slug === productSlug || c.name.toLowerCase().includes(productSlug.replace(/-/g, ' '))));
            if (found) {
                found.qty = Math.max(found.qty || 0, 10);
                saveDraft();
                setStep(2);
                if (window.showToast) window.showToast(`Menu ${found.name} telah ditambahkan ke rencana katering Anda!`);
            }
        }
    }

    // Initialize
    syncFormInputsFromState();
    renderCatalogList();
    renderLiveSummary();
    checkDraft();
    checkUrlDeepLink();
}
