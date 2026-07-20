<?php

namespace App\Filament\Admin\Resources\MasterTechnologies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasterTechnologyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('technology_option')->required(),
                TextInput::make('recommended')->required(),
            ]);
    }
}
