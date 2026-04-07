<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals\Pages;

use App\Filament\Admin\Resources\MasterThicknessExternals\MasterThicknessExternalResource;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterThicknessExternal extends ViewRecord
{
    protected static string $resource = MasterThicknessExternalResource::class;

    protected function getHeaderActions(): array
    {
        return MasterThicknessExternalResource::getViewPageActions();
    }
}
