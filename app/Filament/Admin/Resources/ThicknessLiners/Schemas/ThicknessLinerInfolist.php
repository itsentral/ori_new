<?php

namespace App\Filament\Admin\Resources\ThicknessLiners\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontWeight;

class ThicknessLinerInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Liner Information')
                    ->schema([
                        TextEntry::make('liner_code')
                            ->label('Liner Code')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->color('primary'),


                        TextEntry::make('layers_formula')
                            ->label('Formula layer')
                            ->badge(),

                        TextEntry::make('aplikasi')
                            ->label('Application Support')
                            ->getStateUsing(function ($record) {
                                $cor = match ($record->corrosion) {
                                    1 => 'Low',
                                    2 => 'Medium',
                                    3 => 'High',
                                    default => '-'
                                };
                                $temp = match ($record->temprature) {
                                    1 => 'Low',
                                    2 => 'Medium',
                                    3 => 'High',
                                    default => '-'
                                };
                                return "Corrosion: {$cor} | Temp: {$temp}";
                            })
                            ->badge()
                            ->color('success'),

                        TextEntry::make('thickness_actual')
                            ->label('Thickness Specs')
                            ->suffix(' mm'),

                        TextEntry::make('thickness_teori')
                            ->label('Theoretical Thickness')
                            ->suffix(' mm'),
                    ])
                    ->columns(3) 
                    ->columnSpanFull(),

                Section::make('Layers Breakdown')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('layers')
                            ->label('')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextEntry::make('layer_no')
                                            ->label('Layer No')
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('material_code')
                                            ->label('Code'),
                                        TextEntry::make('resinType.type_name')
                                            ->label('Material Name'),
                                        TextEntry::make('engineering_value')
                                            ->label('Thickness')
                                            ->suffix(' mm')
                                            ->weight(FontWeight::Bold),
                                    ]),
                            ])
                            ->grid(1),
                    ]),
            ]);
    }
}
