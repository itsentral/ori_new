<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps\Schemas;

use App\Models\ThicknessPressureTemp;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ThicknessPressureTempForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Master Data')
                ->description('Pilih parameter utama')
                ->columnSpanFull()
                ->schema([
                    Select::make('temperature')
                        ->label('Temperature')
                        ->options([
                            '65deg' => '65°C',
                            '80deg' => '80°C',
                        ])
                        ->required(),

                    Select::make('master_diameter_id')
                        ->label('Diameter (mm)')
                        ->relationship('diameter', 'diameter_mm')
                        ->searchable()
                        ->preload()
                        ->required(),

                ])->columns(2),

            Section::make('List PN & Thickness')
                ->columnSpanFull()
                ->description('Masukkan daftar PN dan Thickness sesuai tabel')
                ->visible(fn(string $context) => $context === 'create')
                ->schema([
                    Repeater::make('thickness_items')
                        ->label('PN & Thickness List')
                        ->schema([
                            Select::make('master_pressure_nominal_id')
                                ->label('PN')
                                ->relationship(
                                    name: 'pressureNominal',
                                    titleAttribute: 'pn_name',
                                    modifyQueryUsing: fn($query) => $query
                                        ->orderByRaw('LENGTH(pn_name) ASC')
                                        ->orderBy('pn_name', 'asc')
                                )
                                ->searchable()
                                ->preload()
                                ->required()

                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->rules([
                                    function () use ($schema) {
                                        return function (string $attribute, $value, \Closure $fail) use ($schema) {
                                            $formData    = $schema->getRawState();
                                            $diameterId  = $formData['master_diameter_id'] ?? null;
                                            $temperature = $formData['temperature'] ?? null;

                                            if (!$diameterId || !$temperature || !$value) return;

                                            $exists = ThicknessPressureTemp::withoutTrashed()
                                                ->where('master_diameter_id', $diameterId)
                                                ->where('temperature', $temperature)
                                                ->where('master_pressure_nominal_id', $value)
                                                ->exists();

                                            if ($exists) {
                                                $fail("Kombinasi Diameter, Temperature, dan PN ini sudah ada.");
                                            }
                                        };
                                    },
                                ]),

                            TextInput::make('thickness')
                                ->label('Thickness (mm)')
                                ->numeric()
                                ->required(),
                        ])
                        ->columns(2)
                        ->grid(2)
                        ->addActionLabel('Tambah Baris PN')
                        ->reorderable(false)
                        ->required(),
                ]),

            Section::make('Edit Data')
                ->visible(fn(string $context) => $context === 'edit')
                ->schema([
                    Select::make('master_pressure_nominal_id')
                        ->label('PN')
                        ->relationship(
                            name: 'pressureNominal',
                            titleAttribute: 'pn_name',
                            modifyQueryUsing: fn($query) => $query
                                ->orderByRaw('LENGTH(pn_name) ASC')
                                ->orderBy('pn_name', 'asc')
                        )
                        ->disabled(),

                    TextInput::make('thickness')
                        ->label('Thickness (mm)')
                        ->numeric()
                        ->required(),
                ])->columns(2),
        ]);
    }
}
