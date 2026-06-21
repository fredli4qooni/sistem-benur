@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-green-700 mb-2 inline-block">&larr; Kembali ke Daftar Pesanan</a>
    <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan: {{ $order->order_number }}</h1>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
    {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Informasi Pengiriman & Pelanggan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <p class="text-xs text-gray-400 uppercase">Nama Pembudidaya</p>
                    <p class="font-semibold text-gray-800 mt-0.5">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Kontak Telepon</p>
                    <p class="font-semibold text-gray-800 mt-0.5">{{ $order->user->phone ?? '-' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-400 uppercase">Alamat Tujuan Pengiriman</p>
                    <p class="font-semibold text-gray-800 mt-0.5">{{ $order->delivery_address }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Jadwal Kirim Pilihan</p>
                    <p class="font-semibold text-green-700 mt-0.5">{{ date('d M Y', strtotime($order->delivery_date)) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Catatan Tambahan</p>
                    <p class="font-semibold text-gray-800 mt-0.5">{{ $order->notes ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Item yang Dipesan</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-400 border-b text-xs uppercase">
                            <th class="pb-2 pr-4">Nama Produk</th>
                            <th class="pb-2 px-4 text-center">Jumlah</th>
                            <th class="pb-2 px-4 text-right">Harga Satuan</th>
                            <th class="pb-2 pl-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-gray-700">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-3 pr-4 font-medium text-gray-900">{{ $item->product->name }}</td>
                            <td class="py-3 px-4 text-center">{{ $item->quantity }} {{ $item->product->unit }}</td>
                            <td class="py-3 px-4 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="py-3 pl-4 text-right font-bold text-[#1A6B3C]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border">
            <h2 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Aksi & Status</h2>

            <div class="mb-4">
                <span class="text-gray-500 text-sm">Status Saat Ini:</span>
                <span class="font-bold uppercase text-gray-700 ml-2 px-2 py-1 bg-gray-100 rounded text-sm">{{ $order->status }}</span>
            </div>

            @if($order->status === 'pending')
            <div class="border rounded-lg p-2 bg-gray-50 mb-4">
                @if($order->transaction && $order->transaction->proof_image)
                <p class="text-xs text-gray-500 mb-2 text-center">Bukti Transfer:</p>
                <img src="{{ asset('storage/' . $order->transaction->proof_image) }}" class="w-full h-auto rounded object-contain max-h-64 mx-auto" alt="Bukti Transfer">
                @else
                <div class="p-4 text-center text-gray-400 text-sm">
                    Belum ada bukti pembayaran yang diunggah.
                </div>
                @endif
            </div>

            <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-[#1A6B3C] text-white font-bold py-3 rounded-lg hover:bg-[#2E8B57] transition shadow text-center block" {{ (!$order->transaction || !$order->transaction->proof_image) ? 'onclick="return confirm(\'Pelanggan belum mengunggah bukti bayar. Yakin ingin mengonfirmasi pesanan ini secara manual?\')"' : '' }}>
                    ✓ Konfirmasi Pembayaran & Potong Stok
                </button>
            </form>

            @elseif(!in_array($order->status, ['selesai', 'dibatalkan']))
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="mt-4 border-t pt-4">
                @csrf
                @method('PATCH')

                <label class="block text-sm font-medium text-gray-700 mb-2">Update Status Pengiriman</label>
                <div class="flex space-x-2">
                    <select name="status" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-[#1A6B3C] focus:border-[#1A6B3C] text-sm">
                        <option value="dikonfirmasi" {{ $order->status === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="disiapkan" {{ $order->status === 'disiapkan' ? 'selected' : '' }}>Sedang Disiapkan</option>
                        <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dalam Pengiriman</option>
                        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Pesanan Selesai</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm font-semibold">
                        Update
                    </button>
                </div>
            </form>

            @else
            <div class="bg-gray-100 text-gray-600 p-3 rounded-lg text-center font-semibold text-sm">
                Pesanan ini telah berakhir ({{ ucfirst($order->status) }}).
            </div>
            @endif
        </div>
    </div>
</div>
@endsection