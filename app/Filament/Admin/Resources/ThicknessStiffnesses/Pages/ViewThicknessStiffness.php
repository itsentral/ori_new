<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses\Pages;

use App\Filament\Admin\Resources\ThicknessStiffnesses\ThicknessStiffnessResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewThicknessStiffness extends ViewRecord
{
    protected static string $resource = ThicknessStiffnessResource::class;

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
