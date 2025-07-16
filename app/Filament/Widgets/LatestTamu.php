<?php

namespace App\Filament\Widgets;

use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget;
use App\Models\Tamu;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;



class LatestTamu extends TableWidget
{
    protected static ?string $heading = 'Data Tamu Terbaru';
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Tamu::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('jenis')
                ->label('Jenis')
                ->badge()
                ->searchable()
                ->color(fn(string $state) => match (strtolower($state)) {
                    'tamu warga' => 'info',
                    'kurir' => 'warning',
                    'ojek online' => 'success',
                    default => 'gray',
                })
                ->formatStateUsing(function (string $state) {
                    $icon = match (strtolower($state)) {
                        'tamu warga' => '👤',
                        'kurir' => '🚚',
                        'ojek online' => '📍',
                        default => '❓',
                    };

                    return $icon . ' ' . $state;
                }),
            TextColumn::make('plat_nomor')->label('Plat'),
            TextColumn::make('tanggal')->date(),
            TextColumn::make('jam_masuk')->label('Masuk'),
            TextColumn::make('jam_keluar')->label('Keluar'),
            TextColumn::make('posisi')
                ->badge()
                ->color(fn($state) => match (strtolower($state)) {
                    'sudah keluar' => 'success',
                    'sedang didalam' => 'warning',
                    default => 'secondary'
                })
                ->icon(fn($state) => match (strtolower($state)) {
                    'sudah keluar' => 'heroicon-o-check-circle',
                    'sedang didalam' => 'heroicon-o-clock',
                    default => ''
                }),

            TextColumn::make('tujuan')->label('Tujuan'),


        ];
    }


    protected function getTableActions(): array
    {
        return [
            
        ];
    }

    protected function getDefaultTableRecordsPerPage(): int
    {
        return 5;
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
}
