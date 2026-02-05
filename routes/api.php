<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ConectorController;
use App\Http\Controllers\API\MonthsManagerController;

Route::get('/check-api', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/connect', [ConectorController::class, 'connect']);
Route::post('/getMonths', [MonthsManagerController::class, 'getMonths']);

