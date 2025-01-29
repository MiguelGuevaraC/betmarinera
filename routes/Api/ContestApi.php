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
    Route::put('contest/{id}/statusfinalizado', [ContestController::class, 'updateStatusFinalizado']);
    Route::put('contest/{id}/statusactivo', [ContestController::class, 'updateStatusActivo']);
    Route::delete('contest/{id}', [ContestController::class, 'destroy']);

    Route::put('confirm-bet', [ContestController::class, 'confirmbet']);
    Route::get('list-apostadores/{id}', [ContestController::class, 'listapostadoresbycontest']);


    Route::get('exportContestReport/{id}', [ContestController::class, 'exportContestReport'])->name('exportContestReport');
});
