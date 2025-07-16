<?php

namespace App\Exports;

use App\Models\Tamu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TamuExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filter;

    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Tamu::query();
        
        if ($this->filter === 'today') {
            $query->whereDate('tanggal', today());
        }
        
        return $query->orderBy('tanggal', 'desc')
                    ->orderBy('jam_masuk', 'desc')
                    ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Jenis Tamu',
            'Plat Nomor',
            'Tanggal',
            'Jam Masuk',
            'Jam Keluar',
            'Status',
            'Tujuan',
            'Waktu Dibuat'
        ];
    }

    /**
     * @param mixed $tamu
     * @return array
     */
    public function map($tamu): array
    {
        static $no = 1;
        
        return [
            $no++,
            $tamu->jenis_tamu,
            $tamu->plat_nomor ?: '-',
            \Carbon\Carbon::parse($tamu->tanggal)->format('d/m/Y'),
            $tamu->jam_masuk,
            $tamu->jam_keluar ?: '-',
            $tamu->posisi === 'sedang didalam' ? 'Di Dalam' : 'Sudah Keluar',
            $tamu->tujuan,
            $tamu->created_at->format('d/m/Y H:i:s')
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4472C4']
                ],
                'font' => ['color' => ['argb' => 'FFFFFFFF'], 'bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
            // Style all cells
            'A:I' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}