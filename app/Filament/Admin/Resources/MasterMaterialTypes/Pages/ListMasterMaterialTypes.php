<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Pages;

use App\Filament\Admin\Resources\MasterMaterialTypes\MasterMaterialTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterMaterialTypes extends ListRecords
{
    protected static string $resource = MasterMaterialTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => ! auth()->user()->hasRole('costing')
                    || auth()->user()->hasRole('super_admin')),
        ];
    }
}
