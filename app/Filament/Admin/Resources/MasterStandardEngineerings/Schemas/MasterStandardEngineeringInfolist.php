<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings\Schemas;

use App\Models\MasterStandardEngineering;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MasterStandardEngineeringInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('engineering_name'),
                TextEntry::make('engineering_unit')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (MasterStandardEngineering $record): bool => $record->trashed()),
            ]);
    }
}
