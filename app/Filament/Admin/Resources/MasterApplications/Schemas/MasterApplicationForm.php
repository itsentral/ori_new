<?php

namespace App\Filament\Admin\Resources\MasterApplications\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MasterApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('application_name')
                ->label('Application Name')
                ->required()
                ->maxLength(255)
                ->unique(
                    table: 'master_applications',
                    column: 'application_name',
                    ignoreRecord: true
                )
                ->validationMessages([
                    'unique' => 'Nama aplikasi sudah digunakan.',
                ]),
            Textarea::make('description')
                ->label('Description')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }
}
