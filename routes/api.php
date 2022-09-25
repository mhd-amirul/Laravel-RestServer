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
Route::post('login', [authentikasiController::class, 'signin']);

Route::get('mahasiswa', [mahasiswaController::class, 'index']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [authentikasiController::class, 'logout']);
    Route::delete('mahasiswa', [mahasiswaController::class, 'destroy']);
    Route::post('mahasiswa', [mahasiswaController::class, 'store']);
    Route::put('mahasiswa', [mahasiswaController::class, 'update']);
});
