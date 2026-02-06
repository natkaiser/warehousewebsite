<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stock Barang</title>
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
        <h1>📊 LAPORAN STOCK BARANG</h1>
        <p>Dicetak pada: {{ $tanggal }}</p>
    </div>
    
    <div class="info">
        <div class="info-row">
            <span><strong>Total Item:</strong> {{ $total_items }}</span>
            <span><strong>Status:</strong> Aktif</span>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Kode Barang</th>
                <th style="width: 25%;">Nama Barang</th>
                <th style="width: 20%;">Spesifikasi</th>
                <th style="width: 12%; text-align: right;">Stok</th>
                <th style="width: 12%;">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @php $totalStok = 0; @endphp
            @forelse($stocks as $index => $item)
                @php $totalStok += $item->stok; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $item->kode_barang }}</strong></td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->spesifikasi ?? '-' }}</td>
                    <td class="text-right"><strong>{{ $item->stok }}</strong></td>
                    <td>{{ $item->satuan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="color: #999;">
                        Tidak ada data stock barang
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($stocks->count() > 0)
        <div class="summary">
            <div class="summary-row">
                Total Stock Keseluruhan: <span style="color: #e74c3c;">{{ $totalStok }}</span>
            </div>
            <div class="summary-row">
                Jumlah Item: {{ $stocks->count() }}
            </div>
        </div>
    @endif
    
    <div class="footer">
        <p>Laporan otomatis yang dihasilkan oleh sistem warehouse management</p>
        <p style="margin-top: 10px; font-size: 10px;">© {{ date('Y') }} - Semua hak dilindungi</p>
    </div>
</body>
</html>
