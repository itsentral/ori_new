<?php

namespace App\Filament\Admin\Resources\MasterTopCoats\Pages;

use App\Filament\Admin\Resources\MasterTopCoats\MasterTopCoatResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterTopCoat extends ViewRecord
{
    protected static string $resource = MasterTopCoatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
