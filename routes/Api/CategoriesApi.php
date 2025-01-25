<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContestantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('list-categories', [CategoryController::class, 'list']);
    Route::get('list-categories-contest-active', [CategoryController::class, 'list_contest_active']);

    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
    Route::put('categories/{id}/win', [CategoryController::class, 'updateWin']);

});
