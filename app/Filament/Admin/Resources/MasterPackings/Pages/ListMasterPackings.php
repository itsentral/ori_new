<?php

namespace App\Filament\Admin\Resources\MasterPackings\Pages;

use App\Filament\Admin\Resources\MasterPackings\MasterPackingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterPackings extends ListRecords
{
    protected static string $resource = MasterPackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
