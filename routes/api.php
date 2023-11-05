<?php

use App\Http\Controllers\EmailVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\RatingsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/users', [JWTController::class, 'register']);
    Route::post('/users/authenticate', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);
    Route::get('/users', [JWTController::class, 'listUsers']);
    Route::get('/users/{idUser}', [JWTController::class, 'userById']);
    Route::post('/users/updatePassword/{idUser}', [JWTController::class, 'updatePassword']);
    Route::get('/email/verify/{id}', [EmailVerificationController::class, 'verify']);
    Route::post('/createdProperties', [PropertiesController::class, 'createdProperties']);
    Route::get('/properties/{idProperty}', [PropertiesController::class, 'propertiesById']);
    Route::post('/properties/updateProperties/{idProperty}', [PropertiesController::class, 'updateProperties']);
    Route::delete('/properties/deleteProperties/{idProperty}', [PropertiesController::class, 'deleteProperties']);

    Route::post('/holidays', [HolidaysController::class, 'createdHolidays']);
    Route::get('/holidays/{idHolidays}', [HolidaysController::class, 'holidaysById']);
    Route::post('/holidays/updateholidays/{idHolidays}', [HolidaysController::class, 'updateHolidays']);
    Route::delete('/holidays/deleteholidays/{idHolidays}', [HolidaysController::class, 'deleteHolidays']);

    Route::post('/images', [ImagesController::class, 'createdImages']);
    Route::get('/images/{idImages}', [ImagesController::class, 'imagesById']);
    Route::post('/images/updateimages/{idImages}', [ImagesController::class, 'updateImages']);
    Route::delete('/images/deleteimages/{idImages}', [ImagesController::class, 'deleteImages']);

    Route::post('/ratings', [RatingsController::class, 'createdRatings']);
    Route::get('/ratings/{idRatings}', [RatingsController::class, 'ratingsById']);
    Route::post('/ratings/updateratings/{idRatings}', [RatingsController::class, 'updateRatings']);
    Route::delete('/ratings/deleteratings/{idRatings}', [RatingsController::class, 'deleteRatings']);
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});
