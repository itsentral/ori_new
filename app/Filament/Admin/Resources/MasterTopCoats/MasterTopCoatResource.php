<?php

namespace App\Filament\Admin\Resources\MasterTopCoats;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\MasterTopCoats\Pages\ListMasterTopCoats;
use App\Models\MasterTopCoat;
use App\Filament\Admin\Resources\MasterTopCoats\Tables\MasterTopCoatsTable;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MasterTopCoatResource extends BaseResource
{
    protected static ?string $model = MasterTopCoat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'thickness';

    public static function table(Table $table): Table
    {
        return MasterTopCoatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMasterTopCoats::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Developing Product';
    }

    public static function getNavigationLabel(): string
    {
        return 'Top Coat';
    }
}