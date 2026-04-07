<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums\Schemas;

use App\Models\ThicknessVacuum;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ThicknessVacuumInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('master_diameter_id')
                    ->numeric(),
                TextEntry::make('vacuum_type'),
                TextEntry::make('vacuum_load'),
                TextEntry::make('thickness')
                    ->numeric(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ThicknessVacuum $record): bool => $record->trashed()),
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
