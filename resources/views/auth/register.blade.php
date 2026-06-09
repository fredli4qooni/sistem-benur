<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Benur-Q</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="antialiased bg-gray-50 font-sans min-h-screen flex items-center justify-center p-4 py-12">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-2">
                <i class="ph-fill ph-shrimp text-3xl text-[#1A6B3C]"></i>
                <span class="text-2xl font-extrabold text-gray-900 tracking-tight">BENUR-Q</span>
            </a>
            <p class="text-gray-500 text-sm mt-2">Mulai langkah digitalisasi budidaya tambak Anda</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama Pembudidaya" 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-gray-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-user text-lg"></i>
                        </div>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" 
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
                    <label for="phone" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nomor Telepon / WhatsApp</label>
                    <div class="relative">
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="08XXXXXXXXXX" 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-gray-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-phone text-lg"></i>
                        </div>
                    </div>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kata Sandi Baru</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter" 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-gray-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-lock text-lg"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Ulangi Kata Sandi</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-gray-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-lock-key text-lg"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#1A6B3C] text-white font-bold py-3 rounded-lg hover:bg-[#2E8B57] transition-colors shadow-sm text-sm flex items-center justify-center pt-2">
                    Daftar Akun Baru
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-[#1A6B3C] hover:underline">Masuk disini</a>
        </p>
    </div>

</body>
</html>