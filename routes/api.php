<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnakAsuhController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\GalleryController;

Route::post('/login',  [AuthController::class, 'login']);
Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/anak-asuh', [AnakAsuhController::class, 'index']);
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/programs', [LocationController::class, 'index']);
Route::get('/bank-accounts', [BankAccountController::class, 'index']);
Route::get('/donasi', [DonasiController::class, 'index']);
Route::get('/galleries', [GalleryController::class, 'index']);

Route::middleware('auth.jwt')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me',       [AuthController::class, 'me']);

    //Profiles - Identitas panti asuhan amanah yang dapat diedit
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/qris', [ProfileController::class, 'uploadQris']);

    //Anak Asuh
    Route::post('/anak-asuh', [AnakAsuhController::class, 'store']);
    Route::put('/anak-asuh/{id}', [AnakAsuhController::class, 'update']);
    Route::delete('/anak-asuh/{id}', [AnakAsuhController::class, 'destroy']);

    //Location
    Route::post('/locations', [LocationController::class, 'store']);
    Route::put('/locations/{id}', [LocationController::class, 'update']);
    Route::delete('/locations/{id}', [LocationController::class, 'destroy']);

    //programs
    Route::post('/programs', [ProgramController::class, 'store']);
    Route::put('/programs/{id}', [ProgramController::class, 'update']);
    Route::delete('/programs/{id}', [ProgramController::class, 'destroy']);

    //bank accounts
    Route::post('/bank-accounts', [BankAccountController::class, 'store']);
    Route::put('/bank-accounts/{id}', [BankAccountController::class, 'update']);
    Route::delete('/bank-accounts/{id}', [BankAccountController::class, 'destroy']);

    //donations
    Route::post('/donasi', [DonasiController::class, 'store']);
    Route::delete('/donasi/{id}', [DonasiController::class, 'destroy']);

    //gallery
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);
});
