<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LikeController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{user}', [UserController::class, 'show'])->name('test.show');

Route::get('/', [TestController::class, 'index'])->name('test.index');
Route::get('/create', [TestController::class, 'create'])->name('test.create');
Route::post('/store', [TestController::class, 'store'])->name('test.store');
Route::get('/like/{id}', [TestController::class, 'like'])->name('test.like');
Route::get('/unlike/{id}', [TestController::class, 'unlike'])->name('test.unlike');