<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index');
})->middleware(['auth'])->name('index');



Route::middleware(['auth'])->group(function () {
    Route::get('/system', function () {
        return Inertia::render('System');
    })->name('system');
});
