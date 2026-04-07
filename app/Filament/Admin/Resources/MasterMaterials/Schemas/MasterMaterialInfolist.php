<?php

namespace App\Filament\Admin\Resources\MasterMaterials\Schemas;

use App\Models\MasterMaterial;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MasterMaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('material_id'),
                TextEntry::make('material_name'),
                TextEntry::make('trade_name')
                    ->placeholder('-'),
                TextEntry::make('international_name')
                    ->placeholder('-'),
                TextEntry::make('id_material_type')
                    ->numeric(),
                TextEntry::make('id_measurement')
                    ->numeric(),
                TextEntry::make('unit_measurement'),
                TextEntry::make('conversion_value')
                    ->numeric(),
                TextEntry::make('id_packing')
                    ->numeric(),
                TextEntry::make('unit_packing'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('min_stock_day')
                    ->numeric(),
                TextEntry::make('max_stock_day')
                    ->numeric(),
                TextEntry::make('monthly_requirement')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (MasterMaterial $record): bool => $record->trashed()),
            ]);
    }
}
