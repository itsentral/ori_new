<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Schemas;

use App\Models\MasterMaterialType;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MasterMaterialTypeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}