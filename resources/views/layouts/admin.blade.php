<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? "Admin Panel — Yan's Food" }}</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind / Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="h-full font-sans text-stone-800 bg-stone-100 flex flex-col antialiased">

    <!-- TOP NAVBAR -->
    <nav class="fixed top-0 z-40 w-full bg-white border-b border-stone-200">
        <div class="px-4 py-3 lg:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger Button -->
                    <button id="toggle-sidebar-mobile" type="button" class="p-2 text-stone-600 rounded-lg lg:hidden hover:bg-stone-100 focus:outline-none focus:ring-2 focus:ring-stone-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <!-- Brand -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-[#C1440E] flex items-center justify-center text-white font-extrabold text-lg shadow-sm">
                            Y
                        </div>
                        <div class="hidden sm:block leading-tight">
                            <span class="self-center text-base font-extrabold whitespace-nowrap text-stone-900 tracking-wide font-serif">YAN'S FOOD</span>
                            <span class="block text-[10px] uppercase font-bold text-[#C1440E] tracking-widest">Admin Panel</span>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Public Website Preview Link -->
                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-stone-600 bg-stone-100 hover:bg-stone-200 rounded-lg transition">
                        <span>🌐</span>
                        <span>Lihat Web Publik</span>
                    </a>

                    <!-- Admin Profile & Logout -->
                    <div class="flex items-center gap-3 pl-3 border-l border-stone-200">
                        <div class="text-right hidden md:block">
                            <div class="text-xs font-bold text-stone-900">{{ Auth::user()->name ?? 'Owner Yan\'s Food' }}</div>
                            <div class="text-[10px] font-semibold text-[#C1440E]">Owner & Admin Utama</div>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari panel admin?')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg text-xs font-bold transition flex items-center gap-1.5" title="Keluar / Logout">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR WRAPPER -->
    <aside id="sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-16 transition-transform -translate-x-full bg-white border-r border-stone-200 lg:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto sidebar-scroll">
            <ul class="space-y-1 font-medium text-xs">

                {{-- MAIN --}}
                <li class="pt-2 pb-1 px-3 text-[10px] font-black tracking-wider text-stone-400 uppercase">
                    MAIN
                </li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- TRANSACTION --}}
                <li class="pt-4 pb-1 px-3 text-[10px] font-black tracking-wider text-stone-400 uppercase">
                    TRANSACTION
                </li>
                <li>
                    <a href="{{ route('admin.pos.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.pos.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">🛒</span>
                        <span>Kasir</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.transactions.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">🧾</span>
                        <span>Riwayat</span>
                    </a>
                </li>

                {{-- CATALOG --}}
                <li class="pt-4 pb-1 px-3 text-[10px] font-black tracking-wider text-stone-400 uppercase">
                    CATALOG
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.products.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">🍗</span>
                        <span>Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.recipes.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.recipes.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">📖</span>
                        <span>Resep</span>
                    </a>
                </li>


                {{-- FINANCE --}}
                <li class="pt-4 pb-1 px-3 text-[10px] font-black tracking-wider text-stone-400 uppercase">
                    FINANCE
                </li>
                <li>
                    <a href="{{ route('admin.expenses.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.expenses.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">💸</span>
                        <span>Pengeluaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.reports.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">📊</span>
                        <span>Laporan</span>
                    </a>
                </li>

                {{-- SYSTEM --}}
                <li class="pt-4 pb-1 px-3 text-[10px] font-black tracking-wider text-stone-400 uppercase">
                    SYSTEM
                </li>
                <li>
                    <a href="{{ route('admin.printers.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.printers.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">🖨️</span>
                        <span>Printer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">👤</span>
                        <span>Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center p-2.5 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-[#C1440E] text-white font-bold shadow-sm' : 'text-stone-700 hover:bg-stone-100' }}">
                        <span class="text-base mr-3">⚙️</span>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- MOBILE SIDEBAR BACKDROP -->
    <div id="sidebar-backdrop" class="fixed inset-0 z-20 hidden bg-stone-900/50 backdrop-blur-xs lg:hidden"></div>

    <!-- MAIN CONTENT AREA -->
    <div class="p-4 lg:ml-64 pt-20 min-h-screen flex flex-col justify-between">
        <main class="space-y-4">
            {{-- FLASH NOTIFICATIONS --}}
            @if(session('success'))
                <div class="p-4 mb-4 text-xs font-semibold text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-2">
                        <span>✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-800 hover:opacity-75">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-xs font-semibold text-rose-800 bg-rose-50 rounded-xl border border-rose-200 flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-800 hover:opacity-75">✕</button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-4 text-xs font-semibold text-rose-800 bg-rose-50 rounded-xl border border-rose-200" role="alert">
                    <div class="font-bold mb-1">Perhatian! Ada beberapa kesalahan:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- PAGE CONTENT -->
            @yield('content')
        </main>

        <footer class="pt-8 pb-4 text-center text-xs text-stone-400">
            &copy; {{ date('Y') }} Yan's Food Management System. Dikelola oleh Owner & Admin Yan's Food.
        </footer>
    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        const toggleBtn = document.getElementById('toggle-sidebar-mobile');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
            backdrop.addEventListener('click', toggleSidebar);
        }
    </script>

    @stack('scripts')
</body>
</html>
