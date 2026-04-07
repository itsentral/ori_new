<?php

namespace App\Filament\Admin\Resources\MasterTopCoats\Schemas;

use App\Models\MasterTopCoat;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MasterTopCoatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('diameter.id')
                    ->label('Diameter'),
                TextEntry::make('thickness')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (MasterTopCoat $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
