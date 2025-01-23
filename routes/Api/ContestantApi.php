<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConstantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('list-contest', [ConstantController::class, 'list']);

});
