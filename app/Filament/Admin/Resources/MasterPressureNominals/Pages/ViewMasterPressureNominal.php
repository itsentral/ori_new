<?php

namespace App\Filament\Admin\Resources\MasterPressureNominals\Pages;

use App\Filament\Admin\Resources\MasterPressureNominals\MasterPressureNominalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterPressureNominal extends ViewRecord
{
    protected static string $resource = MasterPressureNominalResource::class;

    protected function getHeaderActions(): array
    {
        return MasterPressureNominalResource::getViewPageActions();
    }
}
