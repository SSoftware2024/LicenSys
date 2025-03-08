<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Index');
})->middleware(['auth'])->name('index');

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');
