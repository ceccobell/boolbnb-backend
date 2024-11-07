<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

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


// Registrazione via API
Route::post('register', [RegisteredUserController::class, 'store']);

// Login via API
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Logout via API
Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

Route::get('/get-address-suggestions', [AddressController::class, 'getSuggestions']);
