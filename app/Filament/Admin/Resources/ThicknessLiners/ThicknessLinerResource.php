<?php

namespace App\Filament\Admin\Resources\ThicknessLiners;

use App\Filament\Admin\Resources\ThicknessLiners\Pages\CreateThicknessLiner;
use App\Filament\Admin\Resources\ThicknessLiners\Pages\EditThicknessLiner;
use App\Filament\Admin\Resources\ThicknessLiners\Pages\ListThicknessLiners;
use App\Filament\Admin\Resources\ThicknessLiners\Pages\ViewThicknessLiner;
use App\Filament\Admin\Resources\ThicknessLiners\Schemas\ThicknessLinerForm;
use App\Filament\Admin\Resources\ThicknessLiners\Schemas\ThicknessLinerInfolist;
use App\Filament\Admin\Resources\ThicknessLiners\Tables\ThicknessLinersTable;
use App\Models\ThicknessLiner;
use BackedEnum;
use App\Filament\Admin\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThicknessLinerResource extends BaseResource
{
    protected static ?string $model = ThicknessLiner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'liner_code';

    public static function form(Schema $schema): Schema
    {
        return ThicknessLinerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ThicknessLinerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThicknessLinersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListThicknessLiners::route('/'),
            'create' => CreateThicknessLiner::route('/create'),
            'view' => ViewThicknessLiner::route('/{record}'),
            'edit' => EditThicknessLiner::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Developing Product';
    }

    public static function getNavigationLabel(): string
    {
        return 'Thickness Liner';
    }
}
