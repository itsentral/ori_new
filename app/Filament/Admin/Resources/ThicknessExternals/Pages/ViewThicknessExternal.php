<?php

namespace App\Filament\Admin\Resources\ThicknessExternals\Pages;

use App\Filament\Admin\Resources\ThicknessExternals\ThicknessExternalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewThicknessExternal extends ViewRecord
{
    protected static string $resource = ThicknessExternalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
