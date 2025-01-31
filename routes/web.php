<?php

use App\Http\Controllers\ConstantActiveController;
use App\Http\Controllers\ContestantActiveController;
use App\Http\Controllers\ContestApostadoresController;
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
Route::get('concursos-list', [ContestController::class, 'index'])->name('concurso-list');
Route::get('concursos-active', [ContestantActiveController::class, 'index'])->name('concursos-active');
Route::get('concursos-apostadores', [ContestApostadoresController::class, 'index'])->name('concursos-apostadores');
Route::get('users', [UsersController::class, 'index'])->name('users');

Route::get('403', function () {return view('403');})->name('403');
Route::get('500', function () {return view('500');})->name('500');

