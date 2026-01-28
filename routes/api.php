<?php

use App\Http\Controllers\API\ConectorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/check-api', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/connect', [ConectorController::class, 'connect']);

