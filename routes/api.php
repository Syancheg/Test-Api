<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\JournalController;
use \App\Http\Controllers\Api\AuthorController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/magazine'], function () {
    Route::get('/list', [JournalController::class, 'index']);
    Route::post('/add', [JournalController::class, 'add']);
    Route::post('/update', [JournalController::class, 'update']);
    Route::post('/delete', [JournalController::class, 'delete']);
});

Route::group(['prefix' => '/author'], function () {
    Route::get('/list', [AuthorController::class, 'index']);
    Route::post('/add', [AuthorController::class, 'add']);
    Route::post('/update', [AuthorController::class, 'update']);
    Route::post('/delete', [AuthorController::class, 'delete']);
});