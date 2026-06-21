<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-green-700 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-gray-600">
                        Anda login sebagai: <span class="font-bold uppercase">{{ Auth::user()->role }}</span>
                    </p>
                    
                    <hr class="my-4 border-gray-200">
                    
                    <p class="text-gray-600">
                        Ini adalah halaman dashboard awal. Nanti kita akan memisahkan tampilan ini menjadi Dashboard Admin (dengan grafik & ringkasan penjualan) dan Dashboard User (dengan tren harga & katalog benur).
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
