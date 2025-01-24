<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ContestantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('list-users', [UsersController::class, 'list']);
    Route::get('user/{id}', [UsersController::class, 'show']);
});
