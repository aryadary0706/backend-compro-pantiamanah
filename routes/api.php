<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnakAsuhController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DonationRecordController;

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/profile', [ProfileController::class, 'index']);

Route::get('/anak-asuh', [AnakAsuhController::class, 'index']);

Route::get('/locations', [LocationController::class, 'index']);

Route::get('/programs', [ProgramController::class, 'index']);

Route::get('/bank-accounts', [BankAccountController::class, 'index']);

Route::get('/galleries', [GalleryController::class, 'index']);

Route::get('/donations', [DonationRecordController::class, 'index']);

Route::get('/donations/{id}', [DonationRecordController::class, 'show']);


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('auth.jwt')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | DONATIONS
    |--------------------------------------------------------------------------
    */

    Route::post('/donations', [DonationRecordController::class, 'store']);

    Route::put('/donations/{id}', [DonationRecordController::class, 'update']);

    Route::delete('/donations/{id}', [DonationRecordController::class, 'destroy']);

    Route::get('/donations', [DonationRecordController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | BANK ACCOUNTS
    |--------------------------------------------------------------------------
    */

    Route::post('/bank-accounts', [BankAccountController::class, 'store']);

    Route::put('/bank-accounts/{id}', [BankAccountController::class, 'update']);

    Route::delete('/bank-accounts/{id}', [BankAccountController::class, 'destroy']);

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
    Route::get('/locations', [LocationController::class, 'index']);

    //gallery
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);
    Route::put('/galleries/{id}', [GalleryController::class, 'update']);

    Route::post('/programs', [ProgramController::class, 'store']);
    Route::put('/programs/{id}', [ProgramController::class, 'update']);
    Route::delete('/programs/{id}', [ProgramController::class, 'destroy']);
    Route::get('/programs', [ProgramController::class, 'index']);
});
