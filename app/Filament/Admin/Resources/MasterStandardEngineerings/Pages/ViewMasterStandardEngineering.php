<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings\Pages;

use App\Filament\Admin\Resources\MasterStandardEngineerings\MasterStandardEngineeringResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterStandardEngineering extends ViewRecord
{
    protected static string $resource = MasterStandardEngineeringResource::class;

    protected function getHeaderActions(): array
    {
        return MasterStandardEngineeringResource::getViewPageActions();
    }
}
