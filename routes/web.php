<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Routing\RouteRegistrar;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/index1', function () {
    return view('welcome');
});


Route::get('register', [RegisterController::class, 'register'])->middleware('guest');
Route::post('store', [RegisterController::class, 'store']);
Route::view('home', 'home')->middleware('auth');

Route::view('login', 'auth.login')->middleware('guest')->name('login');
Route::post('authenticate', [LoginController::class, 'authenticate']);
Route::get('logout', [LoginController::class, 'logout']);

Route::view('/','index');
