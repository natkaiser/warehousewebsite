<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stock Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }

        .info {
            margin-bottom: 20px;
            font-size: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background-color: #34495e;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        table tbody tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        table tbody tr:hover {
            background-color: #e8e8e8;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #999;
            text-align: center;
        }

        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #ecf0f1;
            border-radius: 5px;
        }

        .summary-row {
            font-size: 13px;
            margin: 5px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN BARANG KELUAR</h1>
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>

    <div class="info">
        <div class="info-row">
            <span><strong>Total Transaksi:</strong> {{ $history->count() }}</span>
            @if($search)
                <span><strong>Filter:</strong> {{ $search }}</span>
            @else
                <span><strong>Status:</strong> Semua Data</span>
            @endif
        </div>
    </div>

    @if($history->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 10%;">Tanggal</th>
                    <th style="width: 10%;">Kode Barang</th>
                    <th style="width: 20%;">Nama Barang</th>
                    <th style="width: 25%;">Customer</th>
                    <th style="width: 10%; text-align: center;">Jumlah</th>
                    <th style="width: 20%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $totalJumlah = 0; @endphp
                @foreach($history as $index => $row)
                    @php $totalJumlah += $row->jumlah; @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                        <td><strong>{{ $row->stock->kode_barang }}</strong></td>
                        <td>{{ $row->stock->nama_barang }}</td>
                        <td>{{ $row->customer->nama }}</td>
                        <td class="text-center"><strong>{{ $row->jumlah }}</strong></td>
                        <td>{{ $row->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                Total Barang Keluar: <span style="color: #e74c3c;">{{ $totalJumlah }}</span> unit
            </div>
            <div class="summary-row">
                Jumlah Transaksi: {{ $history->count() }}
            </div>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tidak ada data untuk ditampilkan</th>
                </tr>
            </thead>
        </table>
    @endif

    <div class="footer">
        <p>Laporan otomatis yang dihasilkan oleh sistem warehouse management</p>
        <p style="margin-top: 10px; font-size: 10px;">© {{ date('Y') }} - Semua hak dilindungi</p>
    </div>
</body>
</html>
