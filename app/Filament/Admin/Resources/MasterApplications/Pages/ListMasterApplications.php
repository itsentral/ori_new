<?php

namespace App\Filament\Admin\Resources\MasterApplications\Pages;

use App\Filament\Admin\Resources\MasterApplications\MasterApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterApplications extends ListRecords
{
    protected static string $resource = MasterApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
