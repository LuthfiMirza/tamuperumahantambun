<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Tamu;



class AStatistikTamu extends BaseWidget
{

    protected function getStats(): array
    {



        return [
            Stat::make('Tamu Warga', Tamu::where('jenis_tamu', 'tamu warga')->count())
                ->description('Tamu Warga')
                ->color('primary'),

            Stat::make('Kurir', Tamu::where('jenis_tamu', 'kurir')->count())
                ->description('Kurir')
                ->color('warning'),

            Stat::make('Ojek Online', Tamu::where('jenis_tamu', 'ojek online')->count())
                ->description('Ojek Online')
                ->color('info'),

            Stat::make('Lainnya', Tamu::where('jenis_tamu', 'lainnya')->count())
                ->description('Lainnya')
                ->color('gray'),

            Stat::make('Sedang Didalam', Tamu::where('posisi', 'sedang didalam')->count())
                ->description('Status Aktif')
                ->color('success'),

            Stat::make('Sudah Keluar', Tamu::where('posisi', 'sudah keluar')->count())
                ->description('Status keluar')
                ->color('danger'),
        ];
    }
}
