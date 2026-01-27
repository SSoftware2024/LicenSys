<?php

use Illuminate\Http\Request;
use App\Services\API\ConectorService;
use Illuminate\Support\Facades\Route;

Route::get('/check-api', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/connect', [ConectorService::class, 'connect']);

