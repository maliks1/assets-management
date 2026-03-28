<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            margin-bottom: 15px;
        }
        .filter-info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="subtitle">Sistem Manajemen Gudang</div>
        <div class="filter-info">
            @if(count($filterInfo) > 0)
                <strong>Filter:</strong> {{ implode(' | ', $filterInfo) }}
            @endif
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Dicatat Oleh</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @if($transactions->count() > 0)
                @foreach($transactions as $index => $transaction)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $transaction->product->kode_barang ?? '-' }}</td>
                    <td>{{ $transaction->product->nama_barang ?? '-' }}</td>
                    <td class="text-center">
                        @if($transaction->tipe_transaksi == 'masuk')
                            <span class="badge-success">Masuk</span>
                        @else
                            <span class="badge-danger">Keluar</span>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($transaction->jumlah) }}</td>
                    <td>{{ $transaction->user->name ?? '-' }}</td>
                    <td>{{ $transaction->catatan ?? '-' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ $date }} | Sistem Manajemen Gudang
    </div>
</body>
</html>