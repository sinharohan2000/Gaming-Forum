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
Route::view('/signup', 'user.signup')->middleware('usercheck');
Route::view('/signin', 'user.signin')->middleware('usercheck');
Route::view('/forget','user.forget')->middleware('usercheck');
Route::get('/home',[UserController::class,'home'])->middleware('authorize');
Route::get('/logout',[UserController::class,'logout'])->middleware('authorize');
Route::get('/verify/{email}/{token}', [UserController::class, 'verify']);
Route::get('/recover/{email}/{token}', [UserController::class, 'linkvalidation']);
Route::POST('/create', [UserController::class, 'signup']);
Route::POST('/home', [UserController::class, 'login']);
Route::POST('/recover', [UserController::class, 'recover']);
Route::POST('/updatepassword', [UserController::class, 'updatepassword']);
Route::POST('/post',[PostController::class, 'post']);
Route::get('/test',[PostController::class, 'test']);
Route::POST('/searchGamer',[UserController::class,'searchGamer'])->middleware('authorize');
Route::get('follow/{gamername}', [UserController::class, 'follow'])->middleware('authorize');
Route::fallback(function () {
    return view('error');
});
