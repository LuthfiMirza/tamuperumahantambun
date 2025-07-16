<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\TamuResource\Pages;
use App\Filament\Resources\TamuResource\RelationManagers;
use App\Models\Tamu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Support\Enums\ActionSize;
use Carbon\Carbon;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;


class TamuResource extends Resource
{
    protected static ?string $model = \App\Models\Tamu::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Data';
    protected static ?string $pluralLabel = 'Data Tamu';
    protected static ?string $navigationLabel = 'Data Tamu';
    protected static ?string $slug = 'tamu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('gambar')
                    ->label('Foto Tamu')
                    ->image()
                    ->disk('public')
                    ->directory('gambar')
                    ->visibility('private')
                    ->imagePreviewHeight('250')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->preserveFilenames()
                    ->required(),

                ToggleButtons::make('jenis_tamu')
                    ->label('Jenis Tamu')
                    ->options([
                        'Tamu Warga' => 'Tamu Warga ',
                        'Kurir' => 'Kurir',
                        'Ojek Online' => 'Ojek Online',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->icons([
                        'Tamu Warga' => 'heroicon-o-user-group',
                        'Kurir' => 'heroicon-o-truck',
                        'Ojek Online' => 'heroicon-o-map-pin',
                        'Lainnya' => 'heroicon-o-question-mark-circle',
                    ])

                    ->columns(2)
                    ->gridDirection('row')
                    ->inline()
                    ->required(),
                TextInput::make('plat_nomor')->label('Plat Nomor')->required(),
                DatePicker::make('tanggal')->required(),
                TimePicker::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->seconds(true)
                    ->format('H:i:s')
                    ->placeholder('Pilih jam masuk')
                    ->hint('Gunakan format 24 jam (HH:MM:SS)')
                    ->required(),

                TimePicker::make('jam_keluar'),
                ToggleButtons::make('posisi')
                    ->options([
                        'sedang didalam' => 'Sedang Didalam',
                        'sudah keluar' => 'Sudah Keluar',
                    ])
                    ->icons([
                        'sedang didalam' => 'heroicon-o-clock',
                        'sudah keluar'  => 'heroicon-o-check-circle',
                    ])
                    ->inline()
                    ->disableOptionWhen(fn(string $value): bool => $value === 'published'),
                TextInput::make('tujuan')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->disk('public')
                    ->label('Gambar')
                    ->square()
                    ->height(50),

                TextColumn::make('jenis_tamu')
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

                TextColumn::make('plat_nomor')->label('Plat Nomor')
                    ->searchable()
                    ->extraAttributes([
                        'class' => 'px-10   '
                    ]),
                TextColumn::make('tanggal')->date()
                    ->extraAttributes([
                        'class' => 'px-10'
                    ]),
                TextColumn::make('jam_masuk')->time()->label('Jam Masuk')
                    ->extraAttributes([
                        'class' => 'px-10'
                    ]),
                TextColumn::make('jam_keluar')->time()->label('Jam Keluar')
                    ->extraAttributes([
                        'class' => 'px-10'
                    ]),


                TextColumn::make('posisi')
                    ->label('Status')
                    ->badge()
                    ->icon(fn(string $state): string => match (strtolower($state)) {
                        'sudah keluar' => 'heroicon-o-check-circle',
                        'sedang didalam' => 'heroicon-o-clock',
                        default => '',
                    })
                    ->color(fn(string $state): string => match (strtolower($state)) {
                        'sudah keluar' => 'success',
                        'sedang didalam' => 'warning',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->extraAttributes([
                        'class' => 'px-10'
                    ]),

                TextColumn::make('tujuan')
                    ->searchable()
                    ->extraAttributes([
                        'class' => 'px-10'
                    ])
            ])

            ->filters([
                SelectFilter::make('jenis_tamu')
                    ->label('Jenis Tamu')
                    ->options([
                        'Tamu Warga' => 'Tamu Warga',
                        'Ojek Online' => 'Ojek Online',
                        'Kurir' => 'Kurir',
                        'Lainnya' => 'Lainnya',
                    ]),


                SelectFilter::make('posisi')
                    ->label('Status')
                    ->options([
                        'sedang didalam' => 'Di Dalam',
                        'sudah keluar' => 'Sudah Keluar',
                    ]),


                Filter::make('tanggal')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('tanggal', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('tanggal', '<=', $data['until']));
                    }),
            ])

            ->actions([
                Action::make('logout')
                    ->label('Logout')
                    ->color('danger')
                    ->icon('heroicon-o-arrow-right-end-on-rectangle')
                    ->requiresConfirmation()
                    ->visible(fn($record) => str_contains(strtolower($record->posisi), 'dalam'))
                    ->action(function ($record) {
                        $record->update([
                            'jam_keluar' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
                            'posisi' => 'Sudah Keluar',
                        ]);

                        Notification::make()
                            ->title('Tamu berhasil logout')
                            ->success()
                            ->send();
                    }),

                // Grup View/Edit/Delete
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                    ->label('')
                    ->icon('heroicon-o-ellipsis-vertical')
            ])

            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }



    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTamus::route('/'),
            'create' => Pages\CreateTamu::route('/create'),
            'edit' => Pages\EditTamu::route('/{record}/edit'),
        ];
    }
}
