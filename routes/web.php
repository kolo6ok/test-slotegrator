<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\IndexController::class,'index']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/wins', [\App\Http\Controllers\IndexController::class,'wins'])->name('wins');

    Route::get('/draw/get',[\App\Http\Controllers\Api\DrawController::class,'prepareDraw'])->name('draw.get');
    Route::post('/draw/play',[\App\Http\Controllers\Api\DrawController::class,'playDraw'])->name('draw.play');

    Route::get('wins/get',[\App\Http\Controllers\Api\WinsController::class,'getWins'])->name('wins.get');
    Route::post('wins/to-score',[\App\Http\Controllers\Api\WinsController::class,'currencyToScore'])->name('wins.toScore');
    Route::post('wins/take',[\App\Http\Controllers\Api\WinsController::class,'takeWin'])->name('wins.take');
    Route::post('wins/reject',[\App\Http\Controllers\Api\WinsController::class,'rejectWin'])->name('wins.reject');
});
