<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StocksExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    private $stocks;

    public function __construct($stocks = null)
    {
        $this->stocks = $stocks;
    }

    public function collection()
    {
        $stocks = $this->stocks ?? Stock::all();
        
        return $stocks->map(function($item, $index) {
            return [
                'no' => $index + 1,
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->nama_barang,
                'spesifikasi' => $item->spesifikasi ?? '-',
                'stok' => $item->stok,
                'satuan' => $item->satuan,
                'tanggal_dibuat' => $item->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Spesifikasi',
            'Stok',
            'Satuan',
            'Tanggal Dibuat',
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'], // emerald-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'border' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        // Style untuk data rows
        $sheet->getStyle('A2:G' . ($this->collection()->count() + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'border' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        // Center alignment untuk kolom No dan Stok
        $sheet->getStyle('A2:A' . ($this->collection()->count() + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);
        
        $sheet->getStyle('E2:E' . ($this->collection()->count() + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // Alternate row colors (striped)
        for ($i = 2; $i <= $this->collection()->count() + 1; $i++) {
            if ($i % 2 === 0) {
                $sheet->getStyle('A' . $i . ':G' . $i)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB'); // gray-50
            }
        }

        // Set header row height
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }
}
