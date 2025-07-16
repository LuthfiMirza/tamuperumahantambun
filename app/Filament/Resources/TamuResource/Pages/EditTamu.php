<?php

namespace App\Filament\Resources\TamuResource\Pages;

use App\Filament\Resources\TamuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditTamu extends EditRecord
{
    protected static string $resource = TamuResource::class;

    protected function getRedirectUrl(): string
    {
        return TamuResource::getUrl(); // Redirect ke halaman tabel tamu
    }
}
