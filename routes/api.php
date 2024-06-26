<?php

use App\Http\Controllers\PacienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'paciente'], function () {
    Route::get("index", [PacienteController::class, "index"]);
    Route::get("index-by-date", [PacienteController::class, "indexByDate"]);
    Route::get("{pacienteId}/detail-last-indices", [PacienteController::class, "detailLastIndices"]);
    Route::get("{pacienteId}/detail-date-range", [PacienteController::class, "detailDateRange"]);
    Route::get("{pacienteId}/detail-latest-in-date-range", [PacienteController::class, "detailLateDateRange"]);
    Route::get("{pacienteId}", [PacienteController::class, "detail"]);
});
