<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function afterSave(): void
    {
        Notification::make()
            ->success()
            ->title('User berhasil diperbarui!')
            ->send();

        // Redirect ke list (table)
        $this->redirect(UserResource::getUrl('index'));
    }
}
