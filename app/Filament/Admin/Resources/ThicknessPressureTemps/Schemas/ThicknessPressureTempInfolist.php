<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps\Schemas;

use App\Models\ThicknessPressureTemp;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ThicknessPressureTempInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('master_diameter_id')
                    ->numeric(),
                TextEntry::make('master_pressure_nominal_id')
                    ->numeric(),
                TextEntry::make('temperature'),
                TextEntry::make('thickness')
                    ->numeric(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ThicknessPressureTemp $record): bool => $record->trashed()),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
