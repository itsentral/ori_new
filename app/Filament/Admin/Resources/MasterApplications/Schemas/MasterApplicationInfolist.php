<?php

namespace App\Filament\Admin\Resources\MasterApplications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MasterApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('application_name')->label('Application Name'),
            TextEntry::make('application_code')->label('Application Code')->default('-'),
            TextEntry::make('description')->label('Deskripsi')->columnSpanFull()->default('-'),
            TextEntry::make('creator.full_name')->label('Created by')->default('-'),
            TextEntry::make('created_at')->label('Created at')->dateTime(),
        ]);
    }
}
