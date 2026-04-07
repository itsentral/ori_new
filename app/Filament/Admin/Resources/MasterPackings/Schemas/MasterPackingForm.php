<?php

namespace App\Filament\Admin\Resources\MasterPackings\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class MasterPackingForm
{
    public static function configure(Schema $schema, int $category = 2): Schema
    {
        return $schema
            ->components([
                Hidden::make('category_pieces')
                    ->default($category),

                TextInput::make('pieces_code')
                    ->label($category === 2 ? 'Packing Code' : 'Packing Code')
                    ->required()
                    ->rules([
                        fn(Get $get): Unique => Rule::unique('master_pieces', 'pieces_code')
                            ->where('category_pieces', $get('category_pieces'))
                            ->ignore($get('../../id')),
                    ]),

                TextInput::make('pieces_name')
                    ->label($category === 2 ? 'Packing Name' : 'Packing Name')
                    ->required(),

                Textarea::make('remark')
                    ->columnSpanFull(),
            ]);
    }
}
