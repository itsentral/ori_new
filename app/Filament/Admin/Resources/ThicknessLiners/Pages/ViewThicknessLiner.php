<?php

namespace App\Filament\Admin\Resources\ThicknessLiners\Pages;

use App\Filament\Admin\Resources\ThicknessLiners\ThicknessLinerResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewThicknessLiner extends ViewRecord
{
    protected static string $resource = ThicknessLinerResource::class;

    protected function getHeaderActions(): array
    {
        return ThicknessLinerResource::getViewPageActions();
    }
}