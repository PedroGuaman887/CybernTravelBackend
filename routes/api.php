<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FilterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\StatusPropertyController;
use App\Http\Controllers\ReservationsController;

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
    Route::get('/getAllProperties', [PropertiesController::class, 'getAllProperties']);
    //publicaciones de un usuario manejarlo con api

    Route::post('/holidays', [HolidaysController::class, 'createdHolidays']);
    Route::get('/holidays/{idHolidays}', [HolidaysController::class, 'holidaysById']);
    Route::post('/holidays/updateholidays/{idHolidays}', [HolidaysController::class, 'updateHolidays']);
    Route::delete('/holidays/deleteholidays/{idHolidays}', [HolidaysController::class, 'deleteHolidays']);

    Route::post('/images', [ImagesController::class, 'createdImages']);
    Route::get('/images/{idImages}', [ImagesController::class, 'imagesById']);
    Route::post('/images/updateimages/{idImages}', [ImagesController::class, 'updateImages']);
    Route::delete('/images/deleteimages/{idImages}', [ImagesController::class, 'deleteImages']);

    Route::post('/ratings', [RatingsController::class, 'createdRatings']);
    Route::get('/ratings/{idProperty}', [RatingsController::class, 'ratingsByIdProperty']);
    Route::post('/ratings/updateratings/{idRatings}', [RatingsController::class, 'updateRatings']);
    Route::delete('/ratings/deleteratings/{idRatings}', [RatingsController::class, 'deleteRatings']);

    Route::get('/getPropertiesWithCity', [FilterController::class, 'getAllPropertiesWithCity']);
    Route::get('/getUserPosts/{user}', [PropertiesController::class, 'getUserPosts']);

    Route::post('/favorites', [FavoritesController::class, 'createdFavorites']);
    Route::get('/favorites/favoritesByUser/{user_id}', [FavoritesController::class, 'favoritesOfUser']);
    Route::delete('/favorites/{idFavorites}', [FavoritesController::class, 'destroy']);

    Route::post('/requests', [RequestsController::class, 'createdRequests']);
    Route::post('/requests/{idRequests}', [RequestsController::class, 'updateRequests']);
    Route::get('/requests/{idRequests}', [RequestsController::class, 'requestsById']);
    Route::get('/requests', [RequestsController::class, 'getAllRequests']);
    Route::delete('/delete/requests/{idRequests}', [RequestsController::class, 'deleteRequests']);

    Route::post('/StatusPause', [StatusPropertyController::class, 'createStatusPause']);
    Route::delete('/deleteStatusProperties/{idProperty}', [StatusPropertyController::class, 'DeleteStatusProperty']);
    Route::post('/reservations', [ReservationsController::class, 'createdReservation']);
    Route::post('/reservations/{idReservations}', [ReservationsController::class, 'updateReservation']);
    Route::get('/reservations/{idReservations}', [ReservationsController::class, 'reservationById']);
    Route::get('/reservations', [ReservationsController::class, 'getAllReservations']);
    Route::get('/getAllReservationsOfaProperty/{idProperty}', [ReservationsController::class, 'getAllReservationsOfaProperty']);
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});
