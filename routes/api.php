<?php

use App\Http\Controllers\API\V1\YandexMusicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::prefix("sanctum")->namespace("App\Http\Controllers\API")->group(function() {
    Route::post("register", "AuthController@register");
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("projects")->namespace("App\Http\Controllers\API\V1")->group(function() {
    Route::get("/", "ProjectsController@index");
    Route::post("/", "ProjectsController@create");
    Route::delete("/{project_id}", "ProjectsController@delete");
});

Route::prefix("pdf")->namespace("App\Http\Controllers\API\V1")->group(function() {
    Route::get("/", "PdfController@view");
});

Route::get('/yandex-music/{art}', [YandexMusicController::class, 'searchArtist']);
Route::get('/yandex-music/tracks/{id}', [YandexMusicController::class, 'getArtistTracks']);
