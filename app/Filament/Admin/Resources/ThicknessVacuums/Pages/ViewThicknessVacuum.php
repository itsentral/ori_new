<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums\Pages;

use App\Filament\Admin\Resources\ThicknessVacuums\ThicknessVacuumResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewThicknessVacuum extends ViewRecord
{
    protected static string $resource = ThicknessVacuumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(static::$resource::getUrl('index')),
            EditAction::make(),
        ];
    }
}
