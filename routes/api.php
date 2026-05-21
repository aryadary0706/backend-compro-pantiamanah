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


/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);
Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/anak-asuh', [AnakAsuhController::class, 'index']);
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/bank-accounts', [BankAccountController::class, 'index']);
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/donations', [DonationRecordController::class, 'index']);
Route::get('/donations/pagination', [DonationRecordController::class, 'pagination']);
Route::get('/donations/{id}', [DonationRecordController::class, 'show']);
Route::get('/anak-asuh/pagination', [AnakAsuhController::class, 'pagination']);

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('auth.jwt')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me',       [AuthController::class, 'me']);

    /*
    |--------------------------------------------------------------------------
    | DONATIONS
    |--------------------------------------------------------------------------
    */

    Route::post('/donations', [DonationRecordController::class, 'store']);
    Route::delete('/donations/{id}', [DonationRecordController::class, 'destroy']);
    Route::put('/donations/{id}', [DonationRecordController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | BANK ACCOUNTS
    |--------------------------------------------------------------------------
    */

    Route::post('/bank-accounts', [BankAccountController::class, 'store']);
    Route::put('/bank-accounts/{id}', [BankAccountController::class, 'update']);
    Route::delete('/bank-accounts/{id}', [BankAccountController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | PROFILES
    |--------------------------------------------------------------------------
    */

    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/qris', [ProfileController::class, 'uploadQris']);

    /*
    |--------------------------------------------------------------------------
    | ANAK ASUH
    |--------------------------------------------------------------------------
    */

    Route::post('/anak-asuh', [AnakAsuhController::class, 'store']);
    Route::put('/anak-asuh/{id}', [AnakAsuhController::class, 'update']);
    Route::delete('/anak-asuh/{id}', [AnakAsuhController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | LOCATIONS
    |--------------------------------------------------------------------------
    */
    Route::post('/locations', [LocationController::class, 'store']);
    Route::put('/locations/{id}', [LocationController::class, 'update']);
    Route::delete('/locations/{id}', [LocationController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | GALLERIES
    |--------------------------------------------------------------------------
    */
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::put('/galleries/{id}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | PROGRAMS
    |--------------------------------------------------------------------------
    */
    Route::post('/programs', [ProgramController::class, 'store']);
    Route::put('/programs/{id}', [ProgramController::class, 'update']);
    Route::delete('/programs/{id}', [ProgramController::class, 'destroy']);
});
