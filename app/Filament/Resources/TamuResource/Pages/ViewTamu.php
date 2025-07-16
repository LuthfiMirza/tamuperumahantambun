<?php

namespace App\Filament\Resources\TamuResource\Pages;

use App\Filament\Resources\TamuResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;


class ViewTamu extends ViewRecord
{
    protected static string $resource = TamuResource::class;

    protected function getHeaderWidgets(): array
    {
        return [];
    }


    protected function getInfolistSchema(): array
    {
        return [
            Section::make('Detail Tamu')
                ->schema([
                    ImageEntry::make('gambar')
                        ->label('Foto Tamu')
                        ->disk('public')
                        ->hiddenLabel()
                        ->circular(),

                    TextEntry::make('jenis')->label('Jenis'),
                    TextEntry::make('plat_nomor')->label('Plat Nomor'),
                    TextEntry::make('tanggal')->label('Tanggal'),
                    TextEntry::make('jam_masuk')->label('Jam Masuk'),
                    TextEntry::make('jam_keluar')->label('Jam Keluar'),
                    TextEntry::make('posisi')->label('Status'),
                    TextEntry::make('tujuan')->label('Tujuan'),
                ]),
        ];
    }
}
