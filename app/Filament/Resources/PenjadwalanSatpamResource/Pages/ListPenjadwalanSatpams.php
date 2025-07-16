<?php

namespace App\Filament\Resources\PenjadwalanSatpamResource\Pages;

use App\Filament\Resources\PenjadwalanSatpamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Filament\Resources\PenjadwalanSatpamResource\Widgets\InfoPenjadwalan;


class ListPenjadwalanSatpams extends ListRecords
{
    protected static string $resource = PenjadwalanSatpamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getFooterWidgets(): array
{
    return [
        InfoPenjadwalan::class,
    ];
}

}
