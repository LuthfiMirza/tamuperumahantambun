<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjadwalanSatpamResource\Pages;
use App\Models\PenjadwalanSatpam;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;



class PenjadwalanSatpamResource extends Resource
{
    protected static ?string $model = PenjadwalanSatpam::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Penjadwalan Satpam';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Satpam')
                    ->required(),
                Select::make('senin')
                    ->label('Senin')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Malam' => 'Malam',
                        'OFF'   => 'OFF',
                    ])
                    ->required(),
                Select::make('selasa')
                    ->label('Selasa')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Malam' => 'Malam',
                        'OFF'   => 'OFF',
                    ])
                    ->required(),
                Select::make('rabu')
                    ->label('Rabu')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Malam' => 'Malam',
                        'OFF'   => 'OFF',
                    ])
                    ->required(),
                Select::make('kamis')
                    ->label('Kamis')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Malam' => 'Malam',
                        'OFF'   => 'OFF',
                    ])
                    ->required(),
                Select::make('jumat')
                    ->label('Jumat')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Malam' => 'Malam',
                        'OFF'   => 'OFF',
                    ])
                    ->required(),
                Select::make('sabtu')
                    ->label('Sabtu')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Malam' => 'Malam',
                        'OFF'   => 'OFF',
                    ])
                    ->required(),
                Select::make('minggu')
                    ->label('Minggu')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Malam' => 'Malam',
                        'OFF'   => 'OFF',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('senin')
                    ->label('Senin')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'danger',
                        'pagi'        => 'success',
                        'malam'       => 'warning',
                        default       => 'secondary',
                    })
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'heroicon-o-x-circle',
                        'pagi'        => 'heroicon-o-sun',
                        'malam'       => 'heroicon-o-moon',
                        default       => '',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(strtolower($state))),
                TextColumn::make('selasa')
                    ->label('Selasa')->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'danger',
                        'pagi'        => 'success',
                        'malam'       => 'warning',
                        default       => 'secondary',
                    })
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'heroicon-o-x-circle',
                        'pagi'        => 'heroicon-o-sun',
                        'malam'       => 'heroicon-o-moon',
                        default       => '',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(strtolower($state))),
                TextColumn::make('rabu')
                    ->label('Rabu')->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'danger',
                        'pagi'        => 'success',
                        'malam'       => 'warning',
                        default       => 'secondary',
                    })
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'heroicon-o-x-circle',
                        'pagi'        => 'heroicon-o-sun',
                        'malam'       => 'heroicon-o-moon',
                        default       => '',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(strtolower($state))),
                TextColumn::make('kamis')
                    ->label('Kamis')->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'danger',
                        'pagi'        => 'success',
                        'malam'       => 'warning',
                        default       => 'secondary',
                    })
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'heroicon-o-x-circle',
                        'pagi'        => 'heroicon-o-sun',
                        'malam'       => 'heroicon-o-moon',
                        default       => '',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(strtolower($state))),
                TextColumn::make('jumat')
                    ->label('Jumat')->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'danger',
                        'pagi'        => 'success',
                        'malam'       => 'warning',
                        default       => 'secondary',
                    })
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'heroicon-o-x-circle',
                        'pagi'        => 'heroicon-o-sun',
                        'malam'       => 'heroicon-o-moon',
                        default       => '',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(strtolower($state))),
                TextColumn::make('sabtu')
                    ->label('Sabtu')->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'danger',
                        'pagi'        => 'success',
                        'malam'       => 'warning',
                        default       => 'secondary',
                    })
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'heroicon-o-x-circle',
                        'pagi'        => 'heroicon-o-sun',
                        'malam'       => 'heroicon-o-moon',
                        default       => '',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(strtolower($state))),
                TextColumn::make('minggu')
                    ->label('Minggu')->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'danger',
                        'pagi'        => 'success',
                        'malam'       => 'warning', 
                        default       => 'secondary',
                    })
                    ->icon(fn (string $state): string => match (strtolower($state)) {
                        'off'         => 'heroicon-o-x-circle',
                        'pagi'        => 'heroicon-o-sun',
                        'malam'       => 'heroicon-o-moon',
                        default       => '',
                    })
                   
                    

                    ->formatStateUsing(fn ($state) => ucfirst(strtolower($state))),

                    
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjadwalanSatpams::route('/'),
            'create' => Pages\CreatePenjadwalanSatpam::route('/create'),
            'edit' => Pages\EditPenjadwalanSatpam::route('/{record}/edit'),
        ];
    }
}
