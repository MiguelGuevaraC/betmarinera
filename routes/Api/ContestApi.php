<?php

use App\Http\Controllers\ContestController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('list-contest', [ContestController::class, 'list']);
    Route::get('contest-categories/{id}', [ContestController::class, 'listcategories']);
    Route::get('contest-contestants/{id}', [ContestController::class, 'listcontestants']);

    Route::post('contest', [ContestController::class, 'store']);
    Route::get('contest/{id}', [ContestController::class, 'show']);
    Route::put('contest/{id}', [ContestController::class, 'update']);
    Route::delete('contest/{id}', [ContestController::class, 'destroy']);

});
