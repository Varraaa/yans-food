<x-app-layout>
    <x-slot name="title">Daftar Menu & Katalog | Yan's Food</x-slot>

    <!-- Top Banner / Editorial Header -->
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pt-8 pb-6 md:pt-14 md:pb-10">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-6 border-b border-surface-variant/40">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-secondary-container text-on-secondary-fixed-variant">
                    <span class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
                    <span class="font-label-sm tracking-wide uppercase text-xs">Dapur Kuliner Rumahan &bull; Resep Warisan</span>
                </div>
                <h1 class="font-headline-lg text-3xl sm:text-4xl lg:text-5xl text-on-surface tracking-tight font-serif">
                    Daftar Menu Yan's Food
                </h1>
                <p class="font-body-lg text-secondary leading-relaxed text-base sm:text-lg">
                    Semua hidangan dan kudapan kami olah dari bahan pilihan dengan resep rumahan otentik. Silakan pilih menu favorit Anda untuk santap hangat hari ini.
                </p>
            </div>

            <!-- Quick Metrics Strip -->
            <div class="flex items-center gap-4 sm:gap-6 p-4 rounded-2xl bg-surface-container shadow-sm self-start lg:self-auto border border-surface-variant/40">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-surface-warm flex items-center justify-center text-primary-container shadow-sm">
                        <span class="material-symbols-outlined text-[22px]">skillet</span>
                    </div>
                    <div>
                        <div class="font-label-md text-on-surface font-semibold text-sm">100% Halal</div>
                        <div class="font-label-sm text-secondary text-xs">Masakan Higienis</div>
                    </div>
                </div>
                <div class="w-px h-8 bg-surface-variant"></div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-surface-warm flex items-center justify-center text-primary-container shadow-sm">
                        <span class="material-symbols-outlined text-[22px]">timer</span>
                    </div>
                    <div>
                        <div class="font-label-md text-on-surface font-semibold text-sm">Fresh Cooked</div>
                        <div class="font-label-sm text-secondary text-xs">Dibuat Sesuai Order</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Ribbon & Search Bar -->
        <x-category-filter />
    </section>

    <!-- Product Catalog Grid -->
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-6 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="productGrid">
            
            <!-- Item 1: Risol Mayo Beef & Egg -->
            <x-food-card 
                title="Risol Mayo Beef & Egg"
                category="Makanan Ringan"
                categorySlug="ringan"
                price="4.500"
                unit="/ pcs"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuBjfgHLT8kteBQDdMGEQYThIxb74MNHgeJMMckFTZwI0tfkB5PllThnkFkmMUO5Y089SEQcOHCHOw9JYj6LxaQ44donrVlAQKZeLUVnj8oxDimXvxadhnVGnDW2NJHl_tQs3pEacp0T7o_4b-nqDYZRu1G2z4oduRYpzPPtf-3iuN1Cuol6-vvCPun4wS-B4vlw9p3kPKqOZ1jWlOFyt5YPhBhhgmQuii3UUHhbFHAiCHaWLOgPkgHB"
                desc="Mayo homemade creamy dengan smoked beef dan potongan telur rebus berbalut tepung roti emas renyah."
                status="sedia"
                :isFavorite="true" />

            <!-- Item 2: Pisang Coklat Crispy -->
            <x-food-card 
                title="Pisang Coklat Crispy"
                category="Makanan Ringan"
                categorySlug="ringan"
                price="3.500"
                unit="/ pcs"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuDhEq_qfhbhyzfhQayTaoq75HycT7f5SC6DQeMDreglD0Zvhq17xGPZJe1ejQf3tnSRYPDRFrYxFgkPu75dAX0W80yYxNVg_AELoWtWHDypCFtykyNJKV0rm3318FMvSIRN-mD4wSyG1SWpIJpN4AxWc15PB9ObSRXjrfB12Rwaj4pMnQXKuz23o918-tAbM6g5-lBbLo4vIUtnIGfDVzEKMNebYvdIBPwpVDExCZMYmi1Z0ywyuYeX"
                desc="Pisang manis legit dengan coklat premium leleh di dalam balutan kulit pastry renyah khas racikan Yan's Food."
                status="sedia"
                :isFavorite="true" />

            <!-- Item 3: Tahu Bakso Kukus / Goreng -->
            <x-food-card 
                title="Tahu Bakso Kukus/Goreng"
                category="Makanan Ringan"
                categorySlug="ringan"
                price="4.000"
                unit="/ pcs"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuBWCJRdB6spLCGTymtJSbPtZOo9HW9h2e5gDOOhwEBsMleb1NUkgXF2RqgdpqDgWsIiYxLJU-17um6yqSXGfVnPGwhcA2IygU-19yHAwJ6H8ttkpLdFe0g_U7Gabr5SOtTcBleLvWsZ6KOhDrJh1hEyy30IU60mbxUEYVPIIROvocFVMKwDDsiyt7_MiGA16pfu0qPrgAGw3l4iKJgmifbCXjfaPjjJeRokLGbi1mepW0guL4PLjhaF"
                desc="Daging sapi asli berpadu lembutnya tahu pong gurih, disajikan dengan cabai rawit hijau segar menggigit."
                status="sedia"
                :isFavorite="false" />

            <!-- Item 4: Nasi Goreng Jadul Yan's -->
            <x-food-card 
                title="Nasi Goreng Jadul Yan's"
                category="Makanan Berat"
                categorySlug="berat"
                price="22.000"
                unit="/ porsi"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuB0gFjuwYwzc5byRksAoaPaJCo22HZeR2rTD2kcV7En88UcW7vKVQXq9YS8RXfSwxDMdpiV3U3rvbi8G1OfQbMTfoZAmHnswhGp0WoieoCeNQ8KbJd2HC-yzabd_HDxIAXf658sy5Jn906vGgVVOuiJLKspZ5dt_52kF1IsTKSW7x1eMeywP5Hhz8hNEHbfX4iAk2pDJ1bo9jJHEv-bM2JMOM7AiS6nmi8Qg3jusbDPBLRFGaRDDvp5"
                desc="Racikan bumbu ulek terasi khas tempo dulu, suwiran ayam gurih, telur ceplok setengah matang, dan acar timun segar."
                status="sedia"
                :isFavorite="true" />

            <!-- Item 5: Nasi Ayam Sambal Korek -->
            <x-food-card 
                title="Nasi Ayam Sambal Korek"
                category="Makanan Berat"
                categorySlug="berat"
                price="25.000"
                unit="/ porsi"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuDM543C3ZwVvzt62Lw2M-Q5CDKmXT-ukbS3bmxrX9-DanGhxv3EUUIu5HyVxZFu1rfermDZ1Y9j2rcyWDv4nXnmFtNPbNb5EKgXWayFrnH4YKUjmrEFqX7o_57TrrJMlntTCfwXQXKbGE2rSEQWM-UVlPI07QCYrplxX_lOcOuhPMI7H18fZXezbhJCMCUuIWu6iEiyLDcs3sRYYJHRcVIqhZjQvFpuOznqXFFitNwLoizx2U53-dQF"
                desc="Ayam goreng gurih renyah dengan siraman sambal korek bawang pedas nendang, lalapan segar, & nasi hangat."
                status="sedia"
                :isFavorite="false" />

            <!-- Item 6: Nasi Gila Spesial Dapur (Habis) -->
            <x-food-card 
                title="Nasi Gila Spesial Dapur"
                category="Makanan Berat"
                categorySlug="berat"
                price="24.000"
                unit="/ porsi"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuCvbMqJp4vasmNPRn7HlUQ53R3QwrbMiAJGRmOeSP3xoEqc-hb5EkQx28tGjOOddzhbh0BvjFwX_K2C7FkHaJpySF2zidCDs-Bx_mHHA3URhRcMv1OQhfIUJ4SnK1xWUswF-WwKCxa8-zJZmfBBJz1XBLusLQAzk5BcvZvIXzaDl0b5CzAHuTSEZQKFm2axnelXGbXdYgGwaMGpV41iikvWXq7ZllZ-h_pkIUZOUgUcN8KoU_ETwohF"
                desc="Tumisan sosis, bakso sapi, dan telur orak-arik dengan saus racikan manis gurih medok di atas nasi putih."
                status="habis"
                :isFavorite="false" />

            <!-- Item 7: Indomie Nyemek Telur -->
            <x-food-card 
                title="Indomie Nyemek Telur"
                category="Mie Instan"
                categorySlug="mie"
                price="18.000"
                unit="/ porsi"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuARZOQ96wet-CMX5rdD7lCFZyLs1EkrpKnlUC0RR99N8F7qRKAtVDp0zOXrFg0euopAroL4wdJES5KEUP4Mc10u-UzZYXlvj3_U850HmHFdI-2qa02DqfAOUMw-0VbCaGvmAt2949p2eWuHqz3RcdS7ODq1G6OninQUnQZKMoxPO6O-lS3WjYQWINUV6vdxskptYAzfbyMOIB5K2-d37eZht5g2KMxF67gGOJStQ-AFmbk3gNEvgEtd"
                desc="Indomie kuah nyemek kental dengan telur setengah matang, sawi hijau segar, tomat, dan taburan bawang goreng."
                status="sedia"
                :isFavorite="false" />

            <!-- Item 8: Es Kopi Susu Gula Aren -->
            <x-food-card 
                title="Es Kopi Susu Gula Aren"
                category="Minuman Segar"
                categorySlug="minuman"
                price="15.000"
                unit="/ cup"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuDuU3Yxrcih-pg6m2nRhDlGOylXXNiZpcpRJOwpGtbqdy2tID_2dcQH8vFY45VJyojhQ_EhfmASszkIE7eY72DmaCVEuoHwd-g6ry7je_ScQ_2fJ8jLVTp1o_iCgl3eLUn5tGJpOrxa83pkjoHbquHRihUHOkcatbhcowl5ghx9jMRDqgTc1xq11rmDLIGt391ni6_gw1qdmchrGD1pMbRA1MfIPrtdWISTKpeaLC0pLS0h91QGgf47"
                desc="Espresso blend robusta segar dengan gula aren murni dan susu gurih creamy yang pas tanpa rasa manis berlebih."
                status="sedia"
                :isFavorite="false" />

            <!-- Item 9: Es Teh Kampul Jeruk Nipis -->
            <x-food-card 
                title="Es Teh Kampul Jeruk Nipis"
                category="Minuman Segar"
                categorySlug="minuman"
                price="8.000"
                unit="/ cup"
                image="https://lh3.googleusercontent.com/aida-public/AB6AXuBts6_Y8VjNhmV1LnrN6Dm5iR4sSQV3xhLKrMWDJ6fdyqbxY5O9UUI0S756Cpv4FT1Yz-u3S4boBHAif6DwRvoIGDRnvaOAQC6T3FOJTit1ctKXlOxUcwCSHO1NAsIzokrAtdKAhabshRPcb8-79Kx_Y0Npfeb0F49PFjc2JS3S2A5MMw-cxhx3jqPOPn8bT9D07fWrCrU6OzYatoJuHKSSOFKhB75_p_Sr9SRd84JFSYkDWNiu3HvX"
                desc="Teh tubruk wangi melati khas Solo berpadu irisan jeruk nipis segar yang mengambang, dingin menyegarkan tenggorokan."
                status="sedia"
                :isFavorite="false" />
        </div>

        <!-- Empty State Container -->
        <div id="empty-state" class="hidden flex-col items-center justify-center py-16 px-4 text-center">
            <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-primary text-[32px]">soup_kitchen</span>
            </div>
            <h3 class="font-headline-sm text-on-surface font-semibold text-lg mb-1 font-serif">Menu Tidak Ditemukan</h3>
            <p class="font-body-sm text-secondary max-w-xs mb-5">
                Coba cari dengan kata kunci lain atau pilih kategori masakan kami yang lain.
            </p>
            <button type="button" 
                    onclick="document.querySelector('.category-btn[data-filter=\'all\']').click(); document.getElementById('searchInput').value = '';"
                    class="px-5 py-2.5 rounded-xl bg-primary-container text-on-primary font-label-md shadow-sm">
                Tampilkan Semua Menu
            </button>
        </div>
    </section>

    <!-- Banner Layanan Katering & Konsultasi -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 pb-20">
        <div class="relative overflow-hidden bg-sand-bg-alt rounded-3xl p-6 sm:p-8 lg:p-12 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 border border-surface-variant/40">
            <div class="space-y-3 max-w-xl text-center md:text-left">
                <div class="inline-flex items-center gap-2 text-primary font-label-sm font-bold uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-[18px]">corporate_fare</span>
                    <span>Layanan Katering Khusus</span>
                </div>
                <h3 class="font-headline-md text-2xl sm:text-3xl text-on-surface font-serif">
                    Butuh Katering Acara, Arisan, atau Rapat Kantor?
                </h3>
                <p class="font-body-md text-secondary leading-relaxed text-sm sm:text-base">
                    Yan's Food melayani pesanan nasi box, snack box arisan, dan prasmanan mini dengan penyesuaian menu serta bumbu istimewa.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3.5 shrink-0 w-full sm:w-auto">
                <a href="{{ url('/pesan') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-primary-container text-on-primary font-label-md flex items-center justify-center gap-2 shadow-md hover:bg-primary-dark transition-colors">
                    <span class="material-symbols-outlined text-[20px]">assignment</span>
                    <span>Lihat Halaman Pemesanan</span>
                </a>
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Yan's%20Food,%20saya%20mau%20konsultasi%20katering" target="_blank" rel="noopener" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-surface-warm text-on-surface font-label-md flex items-center justify-center gap-2 shadow-sm hover:bg-surface-container transition-colors border border-surface-variant/40">
                    <span class="material-symbols-outlined text-[20px] text-success">chat</span>
                    <span>Konsultasi via WA</span>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
