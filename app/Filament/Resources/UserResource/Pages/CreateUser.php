<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->success()
            ->title('User berhasil dibuat!')
            ->send();

        // Redirect ke list (table)
        $this->redirect(UserResource::getUrl('index'));
    }
}
