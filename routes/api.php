<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMail;

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

Route::post('/auth/login', [UserController::class, 'loginUser'])->name('login');
Route::post('/auth/create', [UserController::class, 'createUser'])->name('createUser');
Route::post('/auth/verify/{token}', [UserController::class, 'verifyUser'])->name('verifyUser');
Route::get('/properties/all', [PropertyController::class, 'getAllProperties'])->name('getAllProperties');
Route::get('/property/{id}', [PropertyController::class, 'getProperty'])->name('getProperty');
Route::get('/properties/search', [PropertyController::class, 'searchProperty'])->name('searchProperty');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/send-test-email', function () {
//     Mail::to('sureboytobi@gmail.com')->send(new AuthMail());
//     return 'Test email sent!';
// });
Route::post('/upload/image', [UserController::class, 'uploadImage'])->name('uploadImage');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/auth/logout', [UserController::class, 'logoutUser'])->name('logoutUser');
    Route::post('/user/profile', [UserController::class, 'updateUserProfile'])->name('updateUserProfile');
    Route::get('/user/profile', [UserController::class, 'getUserProfile'])->name('getUserProfile');


    Route::post('/property', [PropertyController::class, 'createProperty'])->name('createProperty');
    Route::get('/user/properties/all', [PropertyController::class, 'getAllUserProperty'])->name('getAllUserproperty');
    Route::put('/user/property/{id}', [PropertyController::class, 'updateProperty'])->name('updateProperty');
    Route::delete('property/delete/{id}', [PropertyController::class, 'deleteProperty'])->name('deleteProperty');

    Route::post('/bookmark', [FavoriteController::class, 'addItemToFavorites'])->name('addItemToFavorites');
    Route::post('/bookmark/remove', [FavoriteController::class, 'deleteItemFromFavorites'])->name('deleteItemFromFavorites');
    Route::get('/bookmarks', [FavoriteController::class, 'getUserFavorites'])->name('getUserFavorites');

    Route::post('/orders/paystack', [OrderController::class, 'paystackOrder'])->name('paystackOrder');
    Route::post('/orders/flutterwave/initiate', [OrderController::class, 'flutterwaveInitiate'])->name('flutterwaveInitiate');
});

