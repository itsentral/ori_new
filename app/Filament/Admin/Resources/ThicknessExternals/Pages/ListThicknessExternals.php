<?php

namespace App\Filament\Admin\Resources\ThicknessExternals\Pages;

use App\Filament\Admin\Resources\ThicknessExternals\ThicknessExternalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThicknessExternals extends ListRecords
{
    protected static string $resource = ThicknessExternalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
