<?php

namespace App\Filament\Admin\Resources\MasterPressureNominals\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MasterPressureNominalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pn_name')
                    ->required(),
                Textarea::make('remark')
            ]);
    }
}
