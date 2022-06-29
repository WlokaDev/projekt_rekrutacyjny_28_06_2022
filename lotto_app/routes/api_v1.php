<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('api')
    ->group(function() {
        Route::get('/results/get-by-date', [\App\Http\Controllers\v1\ResultsController::class, 'getResultsByDate']);
        Route::get('/results/get-by-number', [\App\Http\Controllers\v1\ResultsController::class, 'getDatesByNumber']);
    });
