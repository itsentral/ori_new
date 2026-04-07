<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Schemas;

use App\Models\MasterStandardEngineering;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Grid;
use Filament\Actions\Action;
use Filament\Schemas\Schema;

class MasterMaterialTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('category_types')
                            ->label('Category')
                            ->options([
                                1 => 'Resin',
                                2 => 'Non Resin',
                            ])
                            ->required()
                            ->native(false),

                        TextInput::make('type_code')
                            ->label('Type Code')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('type_name')
                            ->label('Type Name')
                            ->required(),
                    ]),

                Textarea::make('remark')->columnSpanFull(),

                Repeater::make('engineeringDetails')
                    ->relationship()
                    ->schema([
                        Select::make('engineering_id')
                            ->label('Standard Engineering')
                            ->options(
                                MasterStandardEngineering::all()
                                    ->mapWithKeys(fn($item) => [
                                        $item->id => "{$item->engineering_name} ({$item->engineering_unit})"
                                    ])
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                        TextInput::make('engineering_value')
                            ->label('Value')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->addActionLabel('Tambah Row Engineering')
                    ->collapsible(),
            ]);
    }
}
