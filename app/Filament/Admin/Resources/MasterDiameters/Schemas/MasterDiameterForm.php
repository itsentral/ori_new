<?php

namespace App\Filament\Admin\Resources\MasterDiameters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasterDiameterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('diameter_inch')
                    ->required(),
                TextInput::make('diameter_mm')
                    ->required(),
            ]);
    }
}
