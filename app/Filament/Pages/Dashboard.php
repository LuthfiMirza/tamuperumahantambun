<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\TamuChart;
use App\Filament\Widgets\JenisTamuChart;
use App\Filament\Widgets\StatusTamuChart;
use App\Filament\Widgets\AStatistikTamu;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;

class Dashboard extends BaseDashboard
{

    use BaseDashboard\Concerns\HasFiltersForm;


    protected function getFormStatePath(): ?string
    {
        return 'data';
    }



    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\AStatistikTamu::class,
            \App\Filament\Widgets\KTamuChart::class,
            \App\Filament\Widgets\JenisTamuChart::class,
            \App\Filament\Widgets\LatestTamu::class,

        ];
    }
}
