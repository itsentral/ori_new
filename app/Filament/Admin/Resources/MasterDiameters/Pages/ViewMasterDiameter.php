<?php

namespace App\Filament\Admin\Resources\MasterDiameters\Pages;

use App\Filament\Admin\Resources\MasterDiameters\MasterDiameterResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterDiameter extends ViewRecord
{
    protected static string $resource = MasterDiameterResource::class;

    protected function getHeaderActions(): array
    {
        return MasterDiameterResource::getViewPageActions();
    }
}
