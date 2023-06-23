<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/api/login',[App\Http\Controllers\AuthApi\LoginController::class, 'login']);
Route::post('/api/register', [App\Http\Controllers\AuthApi\RegisterController::class, 'store']);
Route::post('/api/logout', [App\Http\Controllers\AuthApi\LogoutController::class, 'logout']);
Route::middleware(['jwt.verify'])->group(function () {
    Route::post('/api/hitung', [App\Http\Controllers\KalkulatorController::class, 'calculate']);
});
Route::middleware(['auth'])->group(function () {
    Route::post('/ajax/hitung', [App\Http\Controllers\KalkulatorController::class, 'calculate']);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
