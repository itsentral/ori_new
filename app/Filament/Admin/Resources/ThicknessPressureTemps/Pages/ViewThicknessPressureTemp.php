<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps\Pages;

use App\Filament\Admin\Resources\ThicknessPressureTemps\ThicknessPressureTempResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewThicknessPressureTemp extends ViewRecord
{
    protected static string $resource = ThicknessPressureTempResource::class;

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
