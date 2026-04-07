<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Pages;

use App\Filament\Admin\Resources\MasterMaterialTypes\MasterMaterialTypeResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterMaterialType extends ViewRecord
{
    protected static string $resource = MasterMaterialTypeResource::class;

    protected function getHeaderActions(): array
    {
        return MasterMaterialTypeResource::getViewPageActions();
    }
}
