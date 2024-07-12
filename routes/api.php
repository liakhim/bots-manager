<?php

use App\Models\Project;
use App\Models\User;
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

Route::prefix("projects")->middleware('auth:sanctum')->namespace("App\Http\Controllers\API\V1")->group(function() {
    Route::get("/", "ProjectsController@index");
});

