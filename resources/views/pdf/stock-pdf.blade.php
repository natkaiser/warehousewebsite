<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Goods Stock Form</title>
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
            width: 60%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .meta-table td {
            padding: 4px 0;
            font-size: 20px;
            font-weight: 400;
        }

        .meta-label {
            width: 50%;
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
            padding: 7px 8px;
            font-size: 13px;
            font-weight: 400;
        }

        .main-table th {
            text-align: center;
            height: 40px;
        }

        .main-table td {
            text-align: center;
            vertical-align: middle;
            height: 38px;
        }

        .main-table .text-left {
            text-align: left;
        }

        .main-table .text-right {
            text-align: right;
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
</head>
<body>
    <div class="title">goods stock form</div>

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
            <td class="meta-label">Total Item</td>
            <td class="meta-colon">:</td>
            <td class="meta-value">{{ $total_items ?? 0 }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 7%;">No</th>
                <th style="width: 20%;">Product Name</th>
                <th style="width: 14%;">Product Id</th>
                <th style="width: 10%;">Rack</th>
                <th style="width: 20%;">Specification</th>
                <th style="width: 10%;">Quantity</th>
                <th style="width: 9%;">Unit</th>
            </tr>
        </thead>
        <tbody>
            @if(($stocks ?? collect())->count() > 0)
                @foreach($stocks as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $item->nama_barang ?? '-' }}</td>
                        <td>{{ $item->kode_barang ?? '-' }}</td>
                        <td>{{ $item->rak ?? '-' }}</td>
                        <td class="text-left">{{ $item->spesifikasi ?? '-' }}</td>
                        <td class="text-right">{{ $item->stok ?? 0 }}</td>
                        <td>{{ $item->satuan ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>1</td>
                    <td class="text-left">-</td>
                    <td>-</td>
                    <td>-</td>
                    <td class="text-left">-</td>
                    <td class="text-right">0</td>
                    <td>-</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="signature-wrapper">
        <table class="signature-row">
            <tr>
                <td class="signature-col">
                    <div class="signature-line"></div>
                    Checked By
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
            warehouse manager
        </div>
    </div>
</body>
</html>
