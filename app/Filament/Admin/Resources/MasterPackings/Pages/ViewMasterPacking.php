<?php

namespace App\Filament\Admin\Resources\MasterPackings\Pages;

use App\Filament\Admin\Resources\MasterPackings\MasterPackingResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterPacking extends ViewRecord
{
    protected static string $resource = MasterPackingResource::class;

    protected function getHeaderActions(): array
    {
        return MasterPackingResource::getViewPageActions();
    }
}
