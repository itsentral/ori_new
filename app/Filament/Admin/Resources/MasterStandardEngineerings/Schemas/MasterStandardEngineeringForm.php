<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasterStandardEngineeringForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('engineering_name')
                    ->label('Engineering Name')
                    ->required(),
                TextInput::make('engineering_unit')
                    ->label('Unit')
                    ->required()
                    ->placeholder('Contoh: mm, kg, psi'),
            ]);
    }
}
