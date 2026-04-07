<?php

namespace App\Filament\Admin\Resources\MasterTopCoats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasterTopCoatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('diameter_id')
                    ->relationship('diameter', 'id')
                    ->required(),
                TextInput::make('thickness')
                    ->numeric(),
            ]);
    }
}
