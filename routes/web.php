<?php

use App\Enum\TypeUser;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index');
})->middleware(['auth'])->name('index');



Route::middleware(['auth'])->group(function () {

    Route::prefix('system')->name('system')->group(function () {
        Route::get('/', [SystemController::class, 'index']);
        Route::post('/save', [SystemController::class, 'save'])->name('.save');
    });


    Route::prefix('user')->name('user')->group(function () {
        Route::get('/{type}', [UserController::class, 'index'])->whereIn('type', TypeUser::cases());
        Route::get('save/{operation}/{type}/{id?}/', [UserController::class, 'saveView'])
            ->whereIn('operation', ['create','update'])
            ->whereIn('type', TypeUser::cases())
            ->where('id', '[0-9]+')
            ->name('.saveView');
        Route::match(['post', 'patch'],'/save', [UserController::class, 'save'])->name('.save');
    });
});
