<?php

use App\Http\Controllers\BotController;
use App\Http\Controllers\UserController;
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
//Route::get('/user', 'UserController@index');

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
});

Route::group(['prefix' => 'bots'], function () {
   Route::post('/', [BotController::class, 'webhookHandler']);
   Route::post('/create', 'BotController@create');
   Route::post('/update', 'BotController@update');
   Route::post('/delete', 'BotController@delete');
});

