<?php

namespace App\Filament\Admin\Resources\MasterWeightFormulas\Pages;

use App\Filament\Admin\Resources\MasterWeightFormulas\MasterWeightFormulaResource;
use Filament\Resources\Pages\ListRecords;

class ListMasterWeightFormulas extends ListRecords
{
    protected static string $resource = MasterWeightFormulaResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
