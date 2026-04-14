<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Pages;

use App\Filament\Admin\Resources\ThicknessCalculations\ThicknessCalculationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThicknessCalculations extends ListRecords
{
    protected static string $resource = ThicknessCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
