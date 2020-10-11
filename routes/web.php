<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/a', [UserController::class,'index']);
Route::get('/b', [PostController::class,'index']);
Route::get('/signup', [UserController::class,'redirectsignup']);
Route::get('/signin', [UserController::class,'redirectsignin']);
Route::view('/forget','user.forget');
Route::get('/home',[UserController::class,'home']);
Route::get('/logout',[UserController::class,'logout']);
Route::get('/verify/{email}/{token}', [UserController::class, 'verify']);
Route::get('/recover/{email}/{token}', [UserController::class, 'linkvalidation']);
Route::POST('/create', [UserController::class, 'signup']);
Route::POST('/home', [UserController::class, 'login']);
Route::POST('/recover', [UserController::class, 'recover']);
Route::POST('/updatepassword', [UserController::class, 'updatepassword']);
Route::fallback(function () {
    return view('error');
});
