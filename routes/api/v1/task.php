<?php

use App\Http\Controllers\API\V1\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('tasks')->name('tasks.')->group(function () {

    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::get('/search', [TaskController::class, 'search'])->name('search');
    Route::get('/{id}', [TaskController::class, 'show'])->name('show');
    Route::put('/{id}', [TaskController::class, 'update'])->name('update');
    Route::delete('/{id}', [TaskController::class, 'destroy'])->name('destroy');
});