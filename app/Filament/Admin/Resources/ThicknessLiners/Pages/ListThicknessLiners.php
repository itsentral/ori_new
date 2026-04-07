<?php

namespace App\Filament\Admin\Resources\ThicknessLiners\Pages;

use App\Filament\Admin\Resources\ThicknessLiners\ThicknessLinerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThicknessLiners extends ListRecords
{
    protected static string $resource = ThicknessLinerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
