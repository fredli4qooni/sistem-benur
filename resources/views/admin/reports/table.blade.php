<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Benur</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2 style="text-align: center; color: #1A6B3C;">LAPORAN PENJUALAN BENUR</h2>
    <p style="text-align: center; margin-top: -10px;">Periode: {{ date('d M Y', strtotime($startDate)) }} s/d {{ date('d M Y', strtotime($endDate)) }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Nomor Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Status</th>
                <th class="text-right">Nilai Transaksi (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($orders as $index => $order)
                @php $total += $order->total_amount; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL PENDAPATAN</th>
                <th class="text-right" style="color: #1A6B3C; font-weight: bold;">{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
    
    <p style="margin-top: 30px; font-size: 10px; color: #666;">Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
</body>
</html>