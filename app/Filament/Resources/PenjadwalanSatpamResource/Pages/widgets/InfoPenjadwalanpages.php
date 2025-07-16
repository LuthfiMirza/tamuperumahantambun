<?php

namespace App\Widgets;

use Filament\Widgets\Widget;

/**
 * Widget untuk menampilkan informasi shift penjadwalan dan catatan penting untuk Satpam.
 * 
 * Pastikan view Blade tersedia di:
 * resources/views/filament/resources/penjadwalan-satpam-resource/widgets/info-penjadwalan.blade.php
 */
class InfoPenjadwalanPages extends Widget
{
    protected static string $view = 'filament.resources.penjadwalan-satpam-resource.widgets.info-penjadwalan';
}