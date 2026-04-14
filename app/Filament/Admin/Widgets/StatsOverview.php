<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PageVisit;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUser        = User::count();
        $userBaru         = User::whereDate('created_at', today())->count();
        $pengunjungHariIni = PageVisit::whereDate('created_at', today())->count();
        $pengunjungBulanIni = PageVisit::whereMonth('created_at', now()->month)->count();

        return [
            Stat::make('Total User', $totalUser)
                // ->description("$userBaru user baru hari ini")
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Pengunjung Hari Ini', $pengunjungHariIni)
                // ->description('Unique IP yang mengakses web')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Pengunjung Bulan Ini', $pengunjungBulanIni)
                // ->description('Total kunjungan ' . now()->format('F Y'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),
        ];
    }
}