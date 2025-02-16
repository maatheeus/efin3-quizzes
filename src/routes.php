<?php

use Efin3\Quizzes\Http\Controllers\GiftQuestionApiAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['auth:api'])->group(function () {
    Route::post('game', [GiftQuestionApiAdminController::class, 'storeGame']);
    Route::get('game', [GiftQuestionApiAdminController::class, 'getGame']);
    Route::get('game/{id}/', [GiftQuestionApiAdminController::class, 'getGameById']);
    Route::post('game/{id}/', [GiftQuestionApiAdminController::class, 'saveDataGame']);
    Route::put('game/{id}/', [GiftQuestionApiAdminController::class, 'updateGame']);
    Route::delete('game/{id}/', [GiftQuestionApiAdminController::class, 'destroyGame']);
    Route::post('/files/upload', [GiftQuestionApiAdminController::class, 'uploadFile']);

    Route::prefix('admin')->group(function () {
        Route::prefix('quizzes')->group(function () {
            Route::post('create', [GiftQuestionApiAdminController::class, 'store']);
            Route::put('{id}', [GiftQuestionApiAdminController::class, 'update']);
            Route::delete('{id}', [GiftQuestionApiAdminController::class, 'destroy']);
        });
    });
    
    Route::prefix('quizzes')->group(function () {
        Route::get('{id}', [GiftQuestionApiAdminController::class, 'get']);
        Route::prefix('answer')->group(function () {
            Route::post('save', [GiftQuestionApiAdminController::class, 'saveAnswer']);
        });
    });

});
