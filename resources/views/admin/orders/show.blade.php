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

            @if($order->is_cancellation_requested && !in_array($order->status, ['dibatalkan', 'selesai']))
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg mb-4">
                <div class="flex items-start">
                    <i class="ph-fill ph-warning-circle text-xl mr-2 mt-0.5 text-yellow-600"></i>
                    <div>
                        <h4 class="font-bold text-sm">Pengajuan Pembatalan Pelanggan</h4>
                        <p class="text-xs mt-1">Alasan: <span class="font-semibold">{{ $order->cancel_reason }}</span></p>
                    </div>
                </div>
            </div>
            @endif

            @if($order->status === 'pending')
            <div class="bg-blue-50 text-blue-800 text-xs p-3 rounded-lg text-center mb-4 border border-blue-200">
                Menunggu pelanggan menyelesaikan pembayaran via Midtrans.
            </div>
            @elseif(!in_array($order->status, ['selesai', 'dibatalkan']))
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="mt-4">
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

            @if(!in_array($order->status, ['dibatalkan', 'selesai']))
            <div class="mt-6 pt-4 border-t border-gray-200">
                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Stok akan dikembalikan otomatis.');">
                    @csrf
                    <button type="submit" class="w-full bg-white border border-red-200 text-red-600 font-bold py-2.5 rounded-lg hover:bg-red-50 transition-colors text-sm">
                        Batalkan Pesanan (Otoritas Admin)
                    </button>
                </form>
            </div>
            @endif

            @if($order->status === 'dibatalkan' && $order->transaction && $order->transaction->status === 'terkonfirmasi')
            <div class="mt-6 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                <h3 class="font-bold text-orange-800 text-sm mb-2"><i class="ph-fill ph-warning mr-1"></i> Tindakan Diperlukan: Refund</h3>
                <p class="text-xs text-orange-700 mb-4">Pesanan dibatalkan setelah pembayaran dikonfirmasi. Anda harus mengembalikan dana sebesar <strong class="text-black">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> secara manual kepada pelanggan.</p>
                <form action="{{ route('admin.orders.refund', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin sudah mentransfer balik uang pelanggan? Status akan berubah menjadi Dikembalikan.');">
                    @csrf
                    <button type="submit" class="w-full bg-orange-600 text-white font-bold py-2 rounded shadow hover:bg-orange-700 transition-colors text-sm">
                        Tandai Dana Sudah Dikembalikan
                    </button>
                </form>
            </div>
            @endif

            @if($order->status === 'dibatalkan' && $order->transaction && $order->transaction->status === 'dikembalikan')
            <div class="mt-6 p-3 bg-green-50 border border-green-200 rounded-lg text-center">
                <span class="text-green-700 text-xs font-bold"><i class="ph-fill ph-check-circle mr-1 text-sm"></i> Dana telah dikembalikan (Refunded)</span>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
