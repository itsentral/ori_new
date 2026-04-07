<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals\Schemas;

use App\Models\MasterThicknessExternal;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MasterThicknessExternalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('layer'),
                TextEntry::make('thickness')
                    ->numeric(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (MasterThicknessExternal $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
