<?php

use App\Http\Controllers\ConstantActiveController;
use App\Http\Controllers\ContestantActiveController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
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
Route::get('/', function () {
    return view('log-in');
})->name('/');
Route::get('log-in', function () {
    return view('log-in');
})->name('log-in');

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('concurso-list', [ContestController::class, 'index'])->name('concurso-list');
Route::get('concurso-activo', [ContestantActiveController::class, 'index'])->name('concurso-activo');
Route::get('users', [UsersController::class, 'index'])->name('users');