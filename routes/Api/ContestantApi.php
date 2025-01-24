<?php

use App\Http\Controllers\ContestantController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('list-contestants', [ContestantController::class, 'list']);

    Route::post('contestant', [ContestantController::class, 'store']);
    Route::get('contestant/{id}', [ContestantController::class, 'show']);
    Route::put('contestant/{id}', [ContestantController::class, 'update']);
    Route::delete('contestant/{id}', [ContestantController::class, 'destroy']);

});
