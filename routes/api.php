<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnakAsuhController;
use App\Http\Controllers\LocationController;


Route::post('/login',  [AuthController::class, 'login']);

Route::middleware('auth.jwt')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me',       [AuthController::class, 'me']);

    //Profiles - Identitas panti asuhan amanah yang dapat diedit
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'store']);

    //AnakAsuh - Anak Asuh
    Route::apiResource('anak-asuh', AnakAsuhController::class);

    //Location
    Route::post('/locations', [LocationController::class, 'store']);
    Route::put('/locations/{id}', [LocationController::class, 'update']);
    Route::get('/locations', [LocationController::class, 'index']);
    Route::delete('/locations/{id}', [LocationController::class, 'destroy']);
});
