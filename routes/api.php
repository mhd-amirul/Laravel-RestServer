<?php

use App\Http\Controllers\auth\authentikasiController;
use App\Http\Controllers\mahasiswa\mahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [authentikasiController::class, 'signup']);
Route::controller(authentikasiController::class)->group(function () {
    Route::post('login', 'signin');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(authentikasiController::class)->group(function () {
        Route::put('update', 'updateAccount');
        Route::post('logout', 'logout');
    });
    Route::controller(mahasiswaController::class)->group(function () {
        Route::get('mahasiswa','index');
        Route::post('mahasiswa','store');
        Route::delete('mahasiswa','destroy');
        Route::put('mahasiswa','update');
    });
});
