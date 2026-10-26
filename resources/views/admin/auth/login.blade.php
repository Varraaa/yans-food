<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Yan's Food</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo/Favicon Yans Food.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-stone-800 bg-stone-100 flex items-center justify-center p-4 antialiased">
    <div class="max-w-md w-full">
        <!-- BRAND LOGO -->
        <div class="text-center mb-8">
            <div class="inline-block w-24 h-24 rounded-3xl bg-gradient-to-br from-[#D6A253] via-[#C1440E] to-[#8F3209] p-[3px] shadow-xl mb-3">
                <div class="w-full h-full rounded-[21px] bg-[#E2631C] flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/logo/Icon Yans Food.svg') }}" 
                         alt="Yan's Food" 
                         class="w-full h-full object-cover">
                </div>
            </div>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight font-serif">YAN'S FOOD</h1>
            <p class="text-xs text-stone-500 mt-1 uppercase tracking-widest font-bold">Admin Management System</p>
        </div>

        <!-- LOGIN CARD -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-stone-200/80 space-y-5">
            <div>
                <h2 class="text-lg font-bold text-stone-900">Masuk ke Panel Admin</h2>
                <p class="text-xs text-stone-500 mt-0.5">Kelola operasional kasir POS, katalog produk, dan keuangan usaha.</p>
            </div>

            {{-- INFORMASI AKUN DUMMY UNTUK GURU / PENGUJI --}}
            <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50/60 rounded-2xl border border-amber-200/80 text-xs text-stone-800 space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 font-bold text-amber-900 text-xs">
                        <span class="material-symbols-outlined text-[16px] text-[#C1440E]">lock_person</span>
                        <span>Akun Demo / Guru (Penguji)</span>
                    </span>
                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-amber-200/80 text-amber-900">
                        Siap Pakai
                    </span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] bg-white/90 p-2.5 rounded-xl border border-amber-200/60 shadow-xs">
                    <div>
                        <span class="text-stone-500 block text-[10px] font-bold uppercase tracking-wider">Email Dummy:</span>
                        <code class="font-bold text-stone-900 font-mono select-all">guru@yansfood.id</code>
                    </div>
                    <div>
                        <span class="text-stone-500 block text-[10px] font-bold uppercase tracking-wider">Kata Sandi:</span>
                        <code class="font-bold text-stone-900 font-mono select-all">admin123</code>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-0.5">
                    <button 
                        type="button" 
                        onclick="document.getElementById('email').value='guru@yansfood.id';document.getElementById('password').value='admin123';"
                        class="flex-1 py-1.5 px-3 bg-[#C1440E] hover:bg-[#a3380b] text-white font-bold rounded-lg transition text-[11px] flex items-center justify-center gap-1 shadow-xs active:scale-[0.98]"
                    >
                        <span class="material-symbols-outlined text-[14px]">touch_app</span>
                        <span>Isi Akun Guru Otomatis</span>
                    </button>
                    <button 
                        type="button" 
                        onclick="document.getElementById('email').value='admin@yansfood.id';document.getElementById('password').value='password';"
                        class="py-1.5 px-3 bg-stone-200 hover:bg-stone-300 text-stone-700 font-bold rounded-lg transition text-[11px] flex items-center justify-center gap-1 active:scale-[0.98]"
                        title="Isi Akun Owner / Admin"
                    >
                        <span>Akun Owner</span>
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="p-3 text-xs font-semibold text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 text-xs font-semibold text-rose-800 bg-rose-50 rounded-xl border border-rose-200">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3 text-xs font-semibold text-rose-800 bg-rose-50 rounded-xl border border-rose-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email', 'guru@yansfood.id') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border border-stone-300 bg-stone-50 text-stone-900 text-sm focus:ring-2 focus:ring-[#C1440E] focus:outline-none transition"
                        placeholder="guru@yansfood.id"
                    >
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Kata Sandi
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        class="w-full px-4 py-3 rounded-xl border border-stone-300 bg-stone-50 text-stone-900 text-sm focus:ring-2 focus:ring-[#C1440E] focus:outline-none transition"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-stone-600 font-medium">
                        <input type="checkbox" name="remember" class="rounded border-stone-300 text-[#C1440E] focus:ring-[#C1440E]">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 bg-[#C1440E] hover:bg-[#a3380b] active:scale-[0.99] text-white font-bold text-sm rounded-xl shadow-md transition duration-200 flex items-center justify-center gap-2"
                >
                    <span>Masuk ke Dashboard</span>
                    <span>→</span>
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs text-stone-500 hover:text-stone-800 font-semibold inline-flex items-center gap-1 transition">
                <span>← Kembali ke Website Publik</span>
            </a>
        </div>
    </div>
</body>
</html>
