<?php

namespace App\Filament\Admin\Resources\ThicknessExternals;

use App\Filament\Admin\Resources\ThicknessExternals\Pages\CreateThicknessExternal;
use App\Filament\Admin\Resources\ThicknessExternals\Pages\EditThicknessExternal;
use App\Filament\Admin\Resources\ThicknessExternals\Pages\ListThicknessExternals;
use App\Filament\Admin\Resources\ThicknessExternals\Pages\ViewThicknessExternal;
use App\Filament\Admin\Resources\ThicknessExternals\Schemas\ThicknessExternalForm;
use App\Filament\Admin\Resources\ThicknessExternals\Schemas\ThicknessExternalInfoList;
use App\Filament\Admin\Resources\ThicknessExternals\Tables\ThicknessExternalsTable;
use App\Models\ThicknessExternal;
use App\Filament\Admin\Resources\BaseResource;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThicknessExternalResource extends BaseResource
{
    protected static ?string $model = ThicknessExternal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $recordTitleAttribute = 'external_code';

    public static function form(Schema $schema): Schema
    {
        return ThicknessExternalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ThicknessExternalInfoList::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThicknessExternalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListThicknessExternals::route('/'),
            'create' => CreateThicknessExternal::route('/create'),
            'view'   => ViewThicknessExternal::route('/{record}'),
            'edit'   => EditThicknessExternal::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Developing Product';
    }

    public static function getNavigationLabel(): string
    {
        return 'Thickness External';
    }
}