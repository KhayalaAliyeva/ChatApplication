<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('conversation/{userId}',[App\Http\Controllers\MessageController::class, 'conversation'])
        ->name('message.conversation');
Route::post('send-message',[App\Http\Controllers\MessageController::class,'sendMessage'])
        ->name('message.send-message');
// Route::post('send-message', 'MessageController@sendMessage')
//     ->name('message.send-message');
