<?php

namespace App\Filament\Admin\Resources\MasterMaterials\Pages;

use App\Filament\Admin\Resources\MasterMaterials\MasterMaterialResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterMaterial extends ViewRecord
{
    protected static string $resource = MasterMaterialResource::class;

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
