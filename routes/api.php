<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ApartmentSearchController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserApartmentController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BraintreeController;
use App\Http\Controllers\ViewController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addapartment', [ApartmentController::class, 'store']);
    Route::post('/editapartment/{id}', [ApartmentController::class, 'update']);
    Route::delete('/deleteapartment/{id}', [ApartmentController::class, 'destroy']);
    Route::get('/myapartments', [UserApartmentController::class, 'index']);
    Route::post('/myapartments/{apartment}/sponsor', [UserApartmentController::class, 'sponsorApartment']);
});

// Registrazione via API
Route::post('register', [RegisteredUserController::class, 'store']);

// Login via API
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Logout via API
Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

Route::get('/get-address-suggestions', [AddressController::class, 'getSuggestions']);

Route::get('/search-apartments', [ApartmentSearchController::class, 'searchNearbyApartments']);

Route::get('/services', [ServiceController::class, 'index']);

Route::post('/sponsor-apartment', [SponsorshipController::class, 'sponsorApartment']);
Route::get('/packages', [SponsorshipController::class, 'getSponsorPackages']);
Route::get('/sponsoredApartments', [SponsorshipController::class, 'getApartmentsWithActiveSponsorship']);

Route::post('/messages', [MessageController::class, 'store']);
Route::get('/apartments/{apartment_id}/messages', [MessageController::class, 'getMessagesByApartment']);
Route::post('/messages/{message_id}/read', [MessageController::class, 'markAsRead']);

Route::post('/apartments/{apartmentId}/views', [ViewController::class, 'store']);
Route::get('/apartments/{apartmentId}/views', [ViewController::class, 'getViewCount']);
Route::get('/visualizzazioni/settimana', [ViewController::class, 'visualizzazioniSettimanali']);

Route::get('braintree/token', [BraintreeController::class, 'getToken']);
Route::post('braintree/payment', [BraintreeController::class, 'makePayment']);
