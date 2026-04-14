<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Username ini sudah digunakan, silahkan pilih username lain.',
                    ])
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->nullable()
                    ->maxLength(255),

                TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->required(fn(string $context) => $context === 'create')
                    ->confirmed()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(255),

                TextInput::make('password_confirmation')
                    ->password()
                    ->label('Confirm Password')
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrated(false),

                TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nick_name')
                    ->maxLength(255),

                TextInput::make('telephone')
                    ->tel()
                    ->maxLength(20),
                Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),
            ]);
    }
}
