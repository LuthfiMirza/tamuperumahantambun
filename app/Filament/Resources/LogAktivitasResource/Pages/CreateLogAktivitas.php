<?php

namespace App\Filament\Resources\LogAktivitasResource\Pages;

use App\Filament\Resources\LogAktivitasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateLogAktivitas extends CreateRecord
{
    protected static string $resource = LogAktivitasResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->success()
            ->title('Log Aktivitas berhasil dibuat!')
            ->send();

        // Redirect ke list (table)
        $this->redirect(LogAktivitasResource::getUrl('index'));
    }
}