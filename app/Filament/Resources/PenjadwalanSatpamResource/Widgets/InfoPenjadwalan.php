<?php

namespace App\Filament\Resources\PenjadwalanSatpamResource\Widgets;

use Filament\Widgets\Widget;

class InfoPenjadwalan extends Widget
{
    protected static string $view = 'filament.resources.penjadwalan-satpam-resource.widgets.info-penjadwalan';

    protected int | string | array $columnSpan = 'full';
}