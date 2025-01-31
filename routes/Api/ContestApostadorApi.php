<?php

use App\Http\Controllers\ContestApostadoresController;
use App\Http\Controllers\ContestController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('list-contest-apostadores', [ContestApostadoresController::class, 'list']);

    Route::get('exportContestReportMiApuesta/{id}', [ContestController::class, 'exportContestReportMiApuesta'])->name('exportContestReportMiApuesta');
    Route::get('exportContestPDFReportMiApuesta/{id}', [ContestController::class, 'downloadContestReportMiApuesta'])->name('downloadContestReportMiApuesta');
});
