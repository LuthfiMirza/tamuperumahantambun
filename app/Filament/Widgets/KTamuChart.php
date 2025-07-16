<?php

namespace App\Filament\Widgets;

use App\Models\Tamu;
use Filament\Widgets\ChartWidget;

class KTamuChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Kunjungan Tamu';
    protected int | string | array $columnSpan = "md";

    protected function getData(): array
    {
        // Data jumlah tamu per hari (7 hari terakhir)
        $data = Tamu::query()
            ->selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->limit(7)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Tamu',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => '#4f46e5',
                ],
            ],
            'labels' => $data->pluck('tanggal')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M')),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // jenis chart (bar, line, pie)
    }
}
