<?php

namespace App\Filament\Widgets;

use App\Models\Tamu;
use Filament\Widgets\ChartWidget;

class JenisTamuChart extends ChartWidget
{

    protected static ?string $heading = 'Statistik Jenis Tamu';
    protected int | string | array $columnSpan = "md";

    protected function getData(): array
    {
        $data = Tamu::selectRaw('jenis_tamu as jenis, COUNT(*) as total')
            ->groupBy('jenis_tamu')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => ['#213448', '#547792', '#94B4C1', '#ECEFCA'],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $data->pluck('jenis'),
        ];
    }



    protected function getType(): string
    {
        return 'bar';
    }
}
