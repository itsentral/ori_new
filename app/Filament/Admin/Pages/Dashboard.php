<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected string $view = 'filament.admin.pages.dashboard';
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Admin\Widgets\StatsOverview::class,
        ];
    }
}
