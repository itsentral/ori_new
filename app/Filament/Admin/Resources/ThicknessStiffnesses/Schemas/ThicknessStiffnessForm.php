<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ThicknessStiffnessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('master_diameter_id')
                ->label('Diameter (mm)')
                ->relationship('diameter', 'diameter_mm')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('stiffness')
                ->label('Stiffness (SN)')
                ->options([
                    '1250' => '1250',
                    '2500' => '2500',
                    '5000' => '5000',
                    '10000' => '10000',
                ])
                ->required()
                ->native(false),

            TextInput::make('thickness')
                ->label('Thickness (mm)')
                ->numeric()
                ->required(),
        ]);
    }
}