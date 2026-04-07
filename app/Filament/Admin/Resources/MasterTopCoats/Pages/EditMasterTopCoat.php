<?php

namespace App\Filament\Admin\Resources\MasterTopCoats\Pages;

use App\Filament\Admin\Resources\MasterTopCoats\MasterTopCoatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterTopCoat extends EditRecord
{
    protected static string $resource = MasterTopCoatResource::class;

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
