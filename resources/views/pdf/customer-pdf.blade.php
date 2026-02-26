<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Customer</title>
    <style>
        @page {
            margin: 18px 22px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            color: #1f2937;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 14px;
            border-bottom: 2px solid #334155;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #0f172a;
            font-size: 20px;
            letter-spacing: 0.4px;
        }

        .header p {
            margin: 6px 0 0;
            color: #475569;
            font-size: 11px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .meta-table td {
            padding: 4px 0;
            font-size: 11px;
            vertical-align: middle;
        }

        .meta-right {
            text-align: right;
        }

        .meta-pill {
            display: inline-block;
            padding: 3px 8px;
            border: 1px solid #94a3b8;
            border-radius: 3px;
            color: #334155;
            font-size: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-table thead th {
            background-color: #334155;
            color: #fff;
            padding: 7px 8px;
            text-align: left;
            font-weight: 700;
            border: 1px solid #cbd5e1;
            font-size: 11px;
        }

        .data-table tbody td {
            padding: 6px 8px;
            border: 1px solid #d5dbe3;
            font-size: 10.5px;
            vertical-align: top;
            word-break: break-word;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .nowrap {
            white-space: nowrap;
        }

        .empty-row {
            color: #64748b;
            text-align: center;
            padding: 16px 8px !important;
        }

        .footer {
            margin-top: 14px;
            padding-top: 8px;
            border-top: 1px solid #cbd5e1;
            font-size: 10px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DAFTAR CUSTOMER</h1>
        <p>Dicetak pada: {{ $tanggal }}</p>
    </div>

    <table class="meta-table">
        <tr>
            <td><strong>Total Customer:</strong> {{ $total_items }}</td>
            <td class="meta-right">
                <span class="meta-pill">Status: Aktif</span>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 30%;">Nama</th>
                <th style="width: 44%;">Alamat</th>
                <th style="width: 20%;">Telepon</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $c)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $c->nama ?? '-' }}</td>
                    <td>{{ $c->alamat ?? '-' }}</td>
                    <td class="nowrap">{{ $c->telepon ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="empty-row">Tidak ada data customer</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan otomatis yang dihasilkan oleh sistem warehouse management</p>
        <p style="margin-top: 6px;">&copy; {{ date('Y') }} - Semua hak dilindungi</p>
    </div>
</body>
</html>
