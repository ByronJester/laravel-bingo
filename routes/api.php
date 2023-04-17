<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BingoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {

    Route::prefix('bingo')->group(function () {
        Route::post('/cards', [BingoController::class, 'getCards']);
        Route::post('/roll-number', [BingoController::class, 'rollNumber']);
        Route::post('/crossout-number', [BingoController::class, 'crossoutNumber']);
        Route::post('/finish-game', [BingoController::class, 'finishGame']);
    });

});
