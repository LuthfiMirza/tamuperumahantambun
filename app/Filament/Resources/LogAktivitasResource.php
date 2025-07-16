<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogAktivitasResource\Pages;
use App\Models\LogAktivitas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LogAktivitasResource extends Resource
{
    protected static ?string $model = LogAktivitas::class;

    protected static ?string $navigationLabel = 'Log Aktivitas';

    protected static ?string $modelLabel = 'Log Aktivitas';

    protected static ?string $navigationGroup = 'System';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_user')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('aktivitas')
                    ->required(),
                Forms\Components\DateTimePicker::make('waktu')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('aktivitas')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('waktu')
                    ->sortable()
                    ->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
            ])
            ->defaultSort('waktu', 'desc')
            ->filters([
                Tables\Filters\Filter::make('user.name')
                    ->label('Nama User')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama User'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['name'],
                            fn (Builder $query, $name): Builder => $query->whereHas('user', function (Builder $query) use ($name) {
                                $query->where('name', 'like', '%' . $name . '%');
                            })
                        );
                    }),
                Tables\Filters\Filter::make('aktivitas')
                    ->form([
                        Forms\Components\TextInput::make('aktivitas')
                            ->label('Aktivitas'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['aktivitas'],
                            fn (Builder $query, $aktivitas): Builder => $query->where('aktivitas', 'like', '%' . $aktivitas . '%')
                        );
                    }),
                Tables\Filters\Filter::make('waktu')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('waktu', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('waktu', '<=', $date),
                            );
                    }),
            ])
            ->actions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogAktivitas::route('/'),
            'create' => Pages\CreateLogAktivitas::route('/create'),
            'edit' => Pages\EditLogAktivitas::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}