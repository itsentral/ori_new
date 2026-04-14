<?php

namespace App\Filament\Admin\Resources\MasterApplications\Pages;

use App\Filament\Admin\Resources\MasterApplications\MasterApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterApplication extends EditRecord
{
    protected static string $resource = MasterApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
