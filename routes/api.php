<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/login', [UserController::class, 'loginUser'])->name('loginUser');
Route::post('/auth/create', [UserController::class, 'createUser'])->name('createUser');
Route::post('/auth/verify/{token}', [UserController::class, 'verifyUser'])->name('verifyUser');


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/auth/logout', [UserController::class, 'logoutUser'])->name('logoutUser');
    Route::post('/user/profile', [UserController::class, 'updateUserProfile'])->name('updateUserProfile');
    Route::get('/user/profile', [UserController::class, 'getUserProfile'])->name('getUserProfile');

    Route::post('/property', [PropertyController::class, 'createProperty'])->name('createProperty');
    Route::get('/property/{id}', [PropertyController::class, 'getProperty'])->name('getProperty');
    Route::get('/properties/all', [PropertyController::class, 'getAllProperty'])->name('getAllProperty');
    Route::put('/property/{id}', [PropertyController::class, 'updateProperty'])->name('updateProperty');


    Route::post('/orders/paystack', [OrderController::class, 'paystackOrder'])->name('paystackOrder');
    Route::post('/orders/flutterwave/initiate', [OrderController::class, 'flutterwaveInitiate'])->name('flutterwaveInitiate');
});

