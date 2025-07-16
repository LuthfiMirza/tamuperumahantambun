<?php

namespace App\Filament\Resources\TamuResource\Pages;

use App\Filament\Resources\TamuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Tamu;

class CreateTamu extends CreateRecord
{
    protected static string $resource = TamuResource::class;

    protected function getRedirectUrl(): string
    {
        return TamuResource::getUrl(); // redirect ke halaman table/index
    }
}
