<?php

use Illuminate\Support\Facades\Route;

// API Version 1
Route::prefix('v1')->group(function () {
    require __DIR__ . '/api/v1/projects.php';
});

// API Version 2 (for future)
Route::prefix('v2')->name('api.v2.')->group(function () {

});