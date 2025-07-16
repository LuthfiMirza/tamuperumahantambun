<?php

namespace App\Filament\Resources\PenjadwalanSatpamResource\Pages;

use App\Filament\Resources\PenjadwalanSatpamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenjadwalanSatpam extends EditRecord
{
    protected static string $resource = PenjadwalanSatpamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
