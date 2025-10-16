<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SearchController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Admin search endpoint
Route::middleware(['auth:web'])->prefix('admin')->group(function () {
    Route::get('/search', [SearchController::class, 'search'])->name('admin.search');
});
