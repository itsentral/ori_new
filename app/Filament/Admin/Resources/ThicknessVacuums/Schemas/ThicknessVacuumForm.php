<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums\Schemas;

use App\Models\ThicknessVacuum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class ThicknessVacuumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Master Data')
                ->columnSpanFull()
                ->schema([
                    Select::make('vacuum_type')
                        ->label('Type')
                        ->options([
                            'Intermittent' => 'Intermittent',
                            'Continuous'   => 'Continuous',
                        ])
                        ->required()
                        ->disabled(fn($context) => $context === 'edit'),

                    Select::make('master_diameter_id')
                        ->label('Diameter (mm)')
                        ->relationship('diameter', 'diameter_mm')
                        ->searchable()
                        ->preload()
                        ->required(),

                    // Hanya muncul saat Edit
                    Select::make('vacuum_load')
                        ->label('Vacuum Load (Bar)')
                        ->options([
                            '-0.1'  => '0 s/d -0.1',
                            '-0.25' => '-0.1 s/d -0.25',
                            '-0.5'  => '-0.25 s/d -0.5',
                            '-1.0'  => '-0.5 s/d -1.0',
                        ])
                        ->visible(fn($context) => $context === 'edit')
                        ->disabled()
                        ->required(),

                    TextInput::make('thickness')
                        ->label('Thickness (mm)')
                        ->numeric()
                        ->visible(fn($context) => $context === 'edit')
                        ->required(),
                ])->columns(2),

            // Multi Add untuk Create
            Section::make('Multi Add Vacuum Load')
                ->columnSpanFull()
                ->visible(fn($context) => $context === 'create')
                ->schema([
                    Repeater::make('vacuum_items')
                        ->label('Daftar Load & Thickness')
                        ->schema([
                            Select::make('vacuum_load')
                                ->label('Vacuum Load (Bar)')
                                ->options([
                                    '-0.1'  => '0 s/d -0.1',
                                    '-0.25' => '-0.1 s/d -0.25',
                                    '-0.5'  => '-0.25 s/d -0.5',
                                    '-1.0'  => '-0.5 s/d -1.0',
                                ])
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->required()
                                // Validasi: kombinasi type+diameter+load belum ada di DB
                                ->rules([
                                    function () use ($schema) {
                                        return function (string $attribute, $value, \Closure $fail) use ($schema) {
                                            // Ambil data parent dari form state
                                            $formData      = $schema->getRawState();
                                            $diameterid    = $formData['master_diameter_id'] ?? null;
                                            $vacuumType    = $formData['vacuum_type'] ?? null;

                                            if (!$diameterid || !$vacuumType || !$value) return;

                                            $exists = ThicknessVacuum::withoutTrashed()
                                                ->where('master_diameter_id', $diameterid)
                                                ->where('vacuum_type', $vacuumType)
                                                ->where('vacuum_load', $value)
                                                ->exists();

                                            if ($exists) {
                                                $fail("Thickness sudah ada untuk Diameter, Type, dan Vacuum Load '{$value}'");
                                            }
                                        };
                                    },
                                ]),
                            TextInput::make('thickness')
                                ->numeric()
                                ->required(),
                        ])
                        ->columns(2)
                        ->grid(2)
                        ->addActionLabel('Tambah Baris Load'),
                ]),
        ]);
    }
}
