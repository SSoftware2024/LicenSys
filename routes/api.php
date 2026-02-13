<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ConectorController;
use App\Http\Controllers\API\LicenseManagerController;

Route::get('/check-api', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/connect', [ConectorController::class, 'connect']);
Route::post('/getMonths', [LicenseManagerController::class, 'getMonths'])->middleware('auth:sanctum');
Route::get('/getDataLicense', [LicenseManagerController::class, 'getData'])->middleware('auth:sanctum');

