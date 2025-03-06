<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    ds('teste')->label('run')->success();
    return Inertia::render('Index');
})->name('index');

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');
