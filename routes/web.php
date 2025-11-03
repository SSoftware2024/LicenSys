<?php

use Inertia\Inertia;
use App\Enum\TypeUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyGroupController;

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
            ->whereIn('operation', ['create', 'update'])
            ->whereIn('type', TypeUser::cases())
            ->where('id', '[0-9]+')
            ->name('.saveView');
        Route::match(['post', 'patch'], '/save', [UserController::class, 'save'])->name('.save');
        Route::patch('/toggleActivete', [UserController::class, 'toggleActivete'])
            ->middleware('auth_admin')
            ->name('.toggleActivete');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])
            ->where('id', '[0-9]+')
            ->middleware('auth_admin')
            ->name('.delete');
    });
    Route::prefix('company')->name('company')->group(function () {
        Route::get('/', [CompanyController::class, 'index']);
        Route::get('/create_view', [CompanyController::class, 'createView'])->name('.createView');
        Route::post('/create', [CompanyController::class, 'create'])->name('.create');
        Route::patch('/toggleActive/{id}', [CompanyController::class, 'toggleActive'])->name('.toggleActive');
    });
    Route::prefix('company_group')->name('company_group')->group(function () {
        Route::get('/', [CompanyGroupController::class, 'index']);
        Route::post('/create', [CompanyGroupController::class, 'create'])->name('.create');
        Route::patch('/update', [CompanyGroupController::class, 'update'])->name('.update');
        Route::delete('/delete/{id}', [CompanyGroupController::class, 'delete'])->name('.delete');
    });
});
