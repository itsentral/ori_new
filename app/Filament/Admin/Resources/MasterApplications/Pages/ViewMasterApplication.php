<?php

namespace App\Filament\Admin\Resources\MasterApplications\Pages;

use App\Filament\Admin\Resources\MasterApplications\MasterApplicationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterApplication extends ViewRecord
{
    protected static string $resource = MasterApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
