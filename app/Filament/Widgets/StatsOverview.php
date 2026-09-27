<?php

namespace App\Filament\Widgets;

use App\Models\Laporan;
use App\Models\Posko;
use App\Models\Relawan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Relawan', Relawan::count())
                ->description('Relawan Terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Laporan', Laporan::count())
                ->description('Laporan Masuk')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('primary'),
            Stat::make('Posko', Posko::count())
                ->description('Posko Terdaftar')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),
        ];
    }
}
