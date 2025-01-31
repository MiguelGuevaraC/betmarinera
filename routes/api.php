<?php

use App\Http\Controllers\AuthenticationController;
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

Route::post('login', [AuthenticationController::class, 'login']);
Route::post('validatemail', [AuthenticationController::class, 'validatemail']);
Route::post('registerUser', [AuthenticationController::class, 'registerUser']);

Route::group(["middleware" => ["auth:sanctum"]], function () {

    require __DIR__ . '/Api/AuthApi.php';        //AUTHENTICATE
    require __DIR__ . '/Api/ContestApi.php';        //CONTEST
    require __DIR__ . '/Api/UsersApi.php';        //USERS
    require __DIR__ . '/Api/CategoriesApi.php';        //CATEGORIES
    require __DIR__ . '/Api/ContestantApi.php';        //CONTESTANT
    require __DIR__ . '/Api/BetApi.php';        //BET
    require __DIR__ . '/Api/ContestApostadorApi.php';        //CONTEST APOSTADORES
});