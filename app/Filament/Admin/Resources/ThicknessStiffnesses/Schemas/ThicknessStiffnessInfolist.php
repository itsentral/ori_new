<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses\Schemas;

use App\Models\ThicknessStiffness;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ThicknessStiffnessInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('master_diameter_id')
                    ->numeric(),
                TextEntry::make('stiffness'),
                TextEntry::make('thickness')
                    ->numeric(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ThicknessStiffness $record): bool => $record->trashed()),
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
