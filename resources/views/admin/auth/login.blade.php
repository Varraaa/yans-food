<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Yan's Food</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-stone-800 bg-stone-100 flex items-center justify-center p-4 antialiased">
    <div class="max-w-md w-full">
        <!-- BRAND LOGO -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-[#C1440E] items-center justify-center text-white font-extrabold text-3xl shadow-lg mb-3">
                Y
            </div>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight font-serif">YAN'S FOOD</h1>
            <p class="text-xs text-stone-500 mt-1 uppercase tracking-widest font-bold">Admin Management System</p>
        </div>

        <!-- LOGIN CARD -->
        <div class="bg-white p-8 rounded-3xl shadow-xl border border-stone-200/80 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-stone-900">Masuk ke Panel Admin</h2>
                <p class="text-xs text-stone-500 mt-0.5">Kelola operasional katering, kasir POS, dan keuangan usaha.</p>
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
                        value="{{ old('email', 'admin@yansfood.id') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border border-stone-300 bg-stone-50 text-stone-900 text-sm focus:ring-2 focus:ring-[#C1440E] focus:outline-none transition"
                        placeholder="admin@yansfood.id"
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
