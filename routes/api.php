<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ConectorController;
use App\Http\Controllers\API\LicenseManagerController;
use App\Http\Controllers\API\TransferController;

Route::get('/check-api', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/connect', [ConectorController::class, 'connect']);
Route::post('/getMonths', [LicenseManagerController::class, 'getMonths'])->middleware('auth:sanctum');
Route::get('/getDataLicense', [LicenseManagerController::class, 'getData'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->prefix('transfer')->group(function () {
    Route::post('/proccess', [TransferController::class, 'proccess']);
});
