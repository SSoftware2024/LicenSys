<?php

use Inertia\Inertia;
use App\Enum\TypeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyGroupController;
use App\Http\Controllers\HistoricCompanyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;



Route::post('/confirm-password', function (Request $request) {
    if (! Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors([
            'password' => [__('The provided password does not match our records.')]
        ]);
    }
    $request->session()->passwordConfirmed();
})->middleware(['auth', 'throttle:6,1'])->name('password_confirm_custom');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('index');
})->middleware(['auth','signed'])->name('verification.verify');


Route::middleware(['auth','verify_email_admin'])->group(function () {
    Route::match(['get','post'],'/', [DashboardController::class, 'index'])->name('index');

    Route::prefix('system')->name('system')->group(function () {
        Route::get('/', [SystemController::class, 'index']);
        Route::post('/save', [SystemController::class, 'save'])->name('.save');
    });


    Route::prefix('user')->name('user')->group(function () {
        Route::get('/{type}', [UserController::class, 'index'])->whereIn('type', TypeUser::cases());
        Route::get('/profile_edit_view', [UserController::class, 'profileEditView'])->name('.profileEditView');
        Route::patch('/profile_edit', [UserController::class, 'profileEdit'])->name('.profileEdit');
        Route::patch('/update_password', [UserController::class, 'updatePassword'])->name('.updatePassword');
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
        Route::get('/update_view/{id}', [CompanyController::class, 'updateView'])->name('.updateView');
        Route::post('/create', [CompanyController::class, 'create'])->name('.create');
        Route::put('/update', [CompanyController::class, 'update'])->name('.update');
        Route::patch('/toggleActive/{id}', [CompanyController::class, 'toggleActive'])->name('.toggleActive');
        Route::delete('/delete/{id}', [CompanyController::class, 'delete'])->name('.delete');
        Route::post('/loadData', [CompanyController::class, 'loadData'])->name('.loadData');
        Route::post('/loadAllData', [CompanyController::class, 'loadAllData'])->name('.loadAllData');
    });
    Route::prefix('company_group')->name('company_group')->group(function () {
        Route::get('/', [CompanyGroupController::class, 'index']);
        Route::post('/create', [CompanyGroupController::class, 'create'])->name('.create');
        Route::patch('/update', [CompanyGroupController::class, 'update'])->name('.update');
        Route::delete('/delete/{id}', [CompanyGroupController::class, 'delete'])->name('.delete');
    });
    Route::prefix('historic_company')->name('historic_company')->group(function () {
        Route::match(['get','post'],'/', [HistoricCompanyController::class, 'index']);
        Route::patch('/pay', [HistoricCompanyController::class, 'pay'])->name('.pay');
        Route::patch('/removePayment', [HistoricCompanyController::class, 'removePayment'])->name('.removePayment');
    });
    Route::prefix('payment')->name('payment')->group(function () {
        Route::match(['get','post'],'/', [PaymentController::class, 'index']);
    });
    Route::prefix('payment_method')->name('payment_method')->group(function () {
        Route::match(['get','post'],'/', [PaymentMethodController::class, 'index']);
        Route::post('/create', [PaymentMethodController::class, 'create'])->name('.create');
        Route::patch('/update', [PaymentMethodController::class, 'update'])->name('.update');
        Route::delete('/delete/{id}', [PaymentMethodController::class, 'delete'])->name('.delete');
    });
});
