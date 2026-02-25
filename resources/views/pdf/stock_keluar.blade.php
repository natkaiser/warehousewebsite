<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    @if(isset($isForm) && $isForm)
        <title>Goods Expenditure Form</title>
        <style>
            @page {
                margin: 22px;
            }

            body {
                font-family: Arial, sans-serif;
                color: #111;
                font-size: 14px;
            }

            .title {
                margin: 10px 0 16px;
                text-align: center;
                font-size: 30px;
                font-weight: 700;
                text-transform: lowercase;
                letter-spacing: 0.4px;
            }

            .meta-table {
                width: 55%;
                border-collapse: collapse;
                margin-bottom: 12px;
            }

            .meta-table td {
                padding: 4px 0;
                font-size: 20px;
                font-weight: 400;
            }

            .meta-label {
                width: 48%;
            }

            .meta-colon {
                width: 6%;
                text-align: center;
            }

            .meta-value {
                border-bottom: 1px solid #111;
                padding-left: 10px;
            }

            .main-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 6px;
            }

            .main-table th,
            .main-table td {
                border: 1px solid #111;
                font-size: 16px;
                padding: 8px 10px;
            }

            .main-table th {
                text-align: center;
                font-weight: 400;
                height: 46px;
            }

            .main-table td {
                height: 50px;
                text-align: center;
                vertical-align: middle;
                font-weight: 400;
            }

            .main-table .text-left {
                text-align: left;
            }

            .signature-wrapper {
                margin-top: 85px;
            }

            .signature-row {
                width: 100%;
                border-collapse: collapse;
            }

            .signature-col {
                width: 33%;
                text-align: center;
                vertical-align: top;
                font-size: 13px;
                font-weight: 400;
            }

            .signature-gap {
                width: 34%;
            }

            .signature-line {
                width: 300px;
                border-top: 1px solid #111;
                margin: 0 auto 12px;
            }

            .signature-manager {
                margin-top: 55px;
                text-align: center;
                font-size: 13px;
                font-weight: 400;
            }

            .signature-manager .signature-line {
                width: 280px;
            }
        </style>
    @else
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
                color: #fff;
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

            .text-center {
                text-align: center;
            }

            .signatures {
                margin-top: 50px;
                display: flex;
                justify-content: space-between;
                gap: 20px;
            }

            .signature {
                text-align: center;
                flex: 1;
            }

            .signature p {
                margin-bottom: 60px;
                font-weight: bold;
            }

            .signature-line {
                border-bottom: 1px solid #000;
                margin-top: 5px;
                width: 100%;
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
    @endif
</head>
<body>
    @if(isset($isForm) && $isForm)
        <div class="title">Goods Expenditure Form</div>

        <table class="meta-table">
            <tr>
                <td class="meta-label">No. Form</td>
                <td class="meta-colon">:</td>
                <td class="meta-value">{{ $noForm ?? '' }}</td>
            </tr>
            <tr>
                <td class="meta-label">Date</td>
                <td class="meta-colon">:</td>
                <td class="meta-value">{{ $tanggalForm ?? now()->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="meta-label">Customer</td>
                <td class="meta-colon">:</td>
                <td class="meta-value">{{ $customerForm ?? '-' }}</td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 7%;">No</th>
                    <th style="width: 23%;">Product Name</th>
                    <th style="width: 18%;">Product Id</th>
                    <th style="width: 15%;">Quantity</th>
                    <th style="width: 15%;">Quality</th>
                    <th style="width: 22%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $formRows = isset($history) ? $history->values() : collect();
                @endphp

                @if($formRows->count() > 0)
                    @foreach($formRows as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-left">{{ $row->stock->nama_barang ?? '-' }}</td>
                            <td>{{ $row->stock->kode_barang ?? '-' }}</td>
                            <td>{{ $row->jumlah ?? '-' }}</td>
                            <td>{{ $row->kualitas ?: '-' }}</td>
                            <td class="text-left">{{ $row->keterangan ?: '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>1</td>
                        <td class="text-left">-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="text-left">-</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="signature-wrapper">
            <table class="signature-row">
                <tr>
                    <td class="signature-col">
                        <div class="signature-line"></div>
                        Customer
                    </td>
                    <td class="signature-gap"></td>
                    <td class="signature-col">
                        <div class="signature-line"></div>
                        Warehouse Admin
                    </td>
                </tr>
            </table>
            <div class="signature-manager">
                <div class="signature-line"></div>
                Warehouse Manager
            </div>
        </div>
    @else
        <div class="header">
            <h1>LAPORAN BARANG KELUAR</h1>
            <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        </div>

        <div class="info">
            <div class="info-row">
                <span><strong>Total Transaksi:</strong> {{ $history->count() }}</span>
                @if($nama_barang || $nama_customer || $tanggal)
                    <span><strong>Filter:</strong> {{ $nama_barang }} {{ $nama_customer }} {{ $tanggal }}</span>
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
                        <th style="width: 8%;">Tanggal</th>
                        <th style="width: 8%;">Kode Barang</th>
                        <th style="width: 18%;">Nama Barang</th>
                        <th style="width: 20%;">Customer</th>
                        <th style="width: 8%; text-align: center;">Jumlah</th>
                        <th style="width: 10%;">Kualitas</th>
                        <th style="width: 23%;">Keterangan</th>
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
                            <td>{{ $row->kualitas ?? '-' }}</td>
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

        <div class="signatures">
            <div class="signature">
                <p>Pemohon</p>
                <div class="signature-line"></div>
            </div>
            <div class="signature">
                <p>Kepala Gudang</p>
                <div class="signature-line"></div>
            </div>
            <div class="signature">
                <p>Admin Gudang</p>
                <div class="signature-line"></div>
            </div>
        </div>

        <div class="footer">
            <p>Laporan otomatis yang dihasilkan oleh sistem warehouse management</p>
            <p style="margin-top: 10px; font-size: 10px;">&copy; {{ date('Y') }} - Semua hak dilindungi</p>
        </div>
    @endif
</body>
</html>
