<?php

use App\Http\Controllers\ProductCatalogExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/product-catalog/{record}/export', [ProductCatalogExportController::class, 'export'])
        ->name('product-catalog.export');
});