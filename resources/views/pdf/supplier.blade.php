<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Supplier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .date-info {
            text-align: right;
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            background-color: #4CAF50;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        table td {
            padding: 10px;
            font-size: 11px;
            border: 1px solid #ddd;
            border-top: none;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Supplier</h1>
        <p>Sistem Manajemen Gudang</p>
    </div>

    <div class="date-info">
        <p>Tanggal: {{ date('d F Y', strtotime(now())) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Supplier</th>
                <th style="width: 35%;">Alamat</th>
                <th style="width: 20%;">Telepon</th>
                <th style="width: 10%;">Tgl Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $index => $supplier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $supplier->nama }}</td>
                    <td>{{ $supplier->alamat }}</td>
                    <td>{{ $supplier->telepon }}</td>
                    <td>{{ $supplier->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="no-data">Tidak ada data supplier</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Supplier: <strong>{{ count($suppliers) }}</strong> | Generated at: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
