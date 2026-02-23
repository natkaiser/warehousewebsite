<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    @if(isset($isForm) && $isForm)
        <title>Form Pengeluaran Barang</title>
    @else
        <title>Laporan Stock Keluar</title>
    @endif
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

        .form-fields {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-fields table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-fields td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .form-fields .label {
            font-weight: bold;
            width: 30%;
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
</head>
<body>
    @if(isset($isForm) && $isForm)
        <div class="header">
            <h1>FORM PENGELUARAN BARANG</h1>
            <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        </div>

        <div class="form-fields">
            <table>
                <tr>
                    <td class="label">No. Form:</td>
                    <td>____________________</td>
                    <td class="label">Tanggal Pengeluaran:</td>
                    <td>____________________</td>
                </tr>
                <tr>
                    <td class="label">Nama Pemohon:</td>
                    <td>____________________</td>
                    <td class="label">Departemen/Bagian:</td>
                    <td>____________________</td>
                </tr>
            </table>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Nama Barang</th>
                    <th style="width: 10%;">Kode Barang</th>
                    <th style="width: 10%; text-align: center;">Jumlah Diminta</th>
                    <th style="width: 10%; text-align: center;">Jumlah Dikeluarkan</th>
                    <th style="width: 8%;">Satuan</th>
                    <th style="width: 12%;">Kondisi Barang</th>
                    <th style="width: 30%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 10; $i++)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>

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
            <p style="margin-top: 10px; font-size: 10px;">© {{ date('Y') }} - Semua hak dilindungi</p>
        </div>
    @endif
</body>
</html>
