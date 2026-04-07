<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasterThicknessExternalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('layer')
                    ->options([
                        '1V' => '1V',
                        '1M' => '1M',
                        '1M1V' => '1M1V',
                    ])
                    ->required()
                    ->native(false),

                TextInput::make('thickness')
                    ->label('Thickness (mm)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('0.00'),
            ]);
    }
}
