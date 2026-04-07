<?php

namespace App\Filament\Admin\Resources;

use Filament\Resources\Resource;
use Illuminate\Support\Str;

class BaseResource extends Resource
{
    public static function canViewAny(): bool
    {
        $model = static::getPermissionName();
        return auth()->user()->can("view_{$model}") || auth()->user()->can("manage_{$model}");
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('manage_' . static::getPermissionName());
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('manage_' . static::getPermissionName());
    }

    public static function canView($record): bool
    {
        $model = static::getPermissionName();
        return auth()->user()->can("view_{$model}") || auth()->user()->can("manage_{$model}");
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('manage_' . static::getPermissionName());
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('manage_' . static::getPermissionName());
    }

    protected static function getPermissionName(): string
    {
        return Str::snake(class_basename(static::getModel()));
    }

    public static function getRecordActions(): array
    {
        return [
            \Filament\Actions\ViewAction::make()->visible(fn() => static::canView(null)),
            \Filament\Actions\EditAction::make()->visible(fn() => static::canEdit(null)),
            \Filament\Actions\DeleteAction::make()->visible(fn() => static::canDelete(null)),
        ];
    }

    public static function getViewPageActions(): array
    {
        return [
            \Filament\Actions\Action::make('back')
                ->label('Back')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(static::getUrl('index')),
            \Filament\Actions\EditAction::make()
                ->visible(fn() => static::canEdit(null)),
        ];
    }

    public static function getEditPageActions(): array
    {
        return [
            \Filament\Actions\ViewAction::make()
                ->visible(fn() => static::canView(null)), // Menggunakan helper canView
            \Filament\Actions\DeleteAction::make()
                ->visible(fn() => static::canDelete(null)), // Menggunakan helper canDelete
        ];
    }
}
