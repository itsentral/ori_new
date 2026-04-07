<?php

namespace App\Filament\Admin\Resources\MasterUnits\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class MasterUnitForm
{
    public static function configure(Schema $schema, int $category = 1): Schema
    {
        return $schema
            ->components([
                Hidden::make('category_pieces')
                    ->default($category),

                TextInput::make('pieces_code')
                    ->label($category === 1 ? 'Unit Code' : 'Packing Code')
                    ->required()
                    ->rules([
                        fn(Get $get): Unique => Rule::unique('master_pieces', 'pieces_code')
                            ->where('category_pieces', $get('category_pieces'))
                            ->ignore($get('../../id')),
                    ]),

                TextInput::make('pieces_name')
                    ->label($category === 1 ? 'Unit Name' : 'Packing Name')
                    ->required(),

                Textarea::make('remark')
                    ->columnSpanFull(),
            ]);
    }
}
