<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Benur-Q</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="antialiased bg-gray-50 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-2">
                <i class="ph-fill ph-shrimp text-3xl text-[#1A6B3C]"></i>
                <span class="text-2xl font-extrabold text-gray-900 tracking-tight">BENUR-Q</span>
            </a>
            <p class="text-gray-500 text-sm mt-2">Masuk untuk mengelola tambak dan pesanan Anda</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
            @if (session('status'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 p-3 mb-4 rounded-lg text-xs font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com" 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-gray-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-envelope text-lg"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#1A6B3C] hover:underline">Lupa Sandi?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-gray-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-lock text-lg"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="w-4 h-4 text-[#1A6B3C] border-gray-300 rounded focus:ring-[#1A6B3C]">
                    <label for="remember_me" class="ml-2 text-sm font-medium text-gray-600 select-none">Ingat akun saya</label>
                </div>

                <button type="submit" class="w-full bg-[#1A6B3C] text-white font-bold py-3 rounded-lg hover:bg-[#2E8B57] transition-colors shadow-sm text-sm flex items-center justify-center">
                    Masuk Ke Sistem
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-[#1A6B3C] hover:underline">Daftar sekarang</a>
        </p>
    </div>

</body>
</html>