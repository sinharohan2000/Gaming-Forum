<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Notification;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ChatController;
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
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/d',function(){
	return view('user.livesearch');
});
Route::post('/send', [ChatController::class,'send']);
Route::get('/a', [UserController::class,'index']);
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
Route::POST('/uppost',[PostController::class, 'uppost']);
Route::get('/test',[PostController::class, 'test']);
Route::post('follow', [UserController::class, 'follow'])->middleware('authorize');
Route::get('post/{postid}', [PostController::class, 'getpost'])->middleware('authorize');
Route::post('/commentpost' , [PostController::class, 'commentpost'])->middleware('authorize');
Route::post('/rating' , [PostController::class, 'rating'])->middleware('authorize');
Route::post('/ratingfetch' , [PostController::class, 'ratingfetch'])->middleware('authorize');
Route::post('/support' , [PostController::class, 'support'])->middleware('authorize');
Route::get('/notification' ,[Notification::class,'fetchnotification'])->middleware('authorize');
Route::POST('/search',[PostController::class,'search']);
Route::get('/profile',[UserController::class,'profile'])->middleware('authorize');
Route::get('/gamerprofile/{id}',[UserController::class,'gamerprofile'])->middleware('authorize');
Route::get('/update',function(){
	return view('user.update');
})->middleware('authorize');
Route::post('/update',[UserController::class,'update'])->middleware('authorize');
Route::post('/changeprofile',[UserController::class,'changeprofile'])->middleware('authorize');
Route::get('/redirect', [GoogleLoginController::class,'redirect']);
Route::get('/callback', [GoogleLoginController::class,'callback']);
Route::get('/updateusername',function(){
	return view('user.updateusername');
})->middleware('authorize');
Route::post('/updateusername',[UserController::class,'updateusername'])->middleware('authorize');
Route::post('/avail',[UserController::class,'avail']);
Route::get('/chat/{receiver}', [ChatController::class,'chat']);
Route::get('/chats', [ChatController::class,'chats']);
Route::fallback(function () {
    return view('error');
});
