<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\ShortsController;

Route::group(['middleware' => ['api']], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/logout', [UserController::class, 'logout']);

    Route::post('/url-short', [ApiController::class, 'short_view']);

    Route::group( [ 'prefix' => 'shorts', 'middleware' => ['auth:web,api']],  function ()
    {
        Route::get('/', [ShortsController::class, 'index']);
        Route::post('/create', [ShortsController::class, 'create']);
        Route::get('/{id}', [ShortsController::class, 'short_info']);
        Route::get('delete/{shorts}', [ShortsController::class, 'delete']);
    });


});
