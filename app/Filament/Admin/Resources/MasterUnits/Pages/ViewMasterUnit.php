<?php

namespace App\Filament\Admin\Resources\MasterUnits\Pages;

use App\Filament\Admin\Resources\MasterUnits\MasterUnitResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterUnit extends ViewRecord
{
    protected static string $resource = MasterUnitResource::class;

    protected function getHeaderActions(): array
    {
        return MasterUnitResource::getViewPageActions();
    }
}
