<?php

use Efin3\Quizzes\Http\Controllers\GiftQuestionApiAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['auth:api'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('quizzes')->group(function () {
            Route::post('create', [GiftQuestionApiAdminController::class, 'store']);
        });
    });

    Route::prefix('quizzes')->group(function () {
        Route::prefix('answer')->group(function () {
            Route::post('save', [GiftQuestionApiAdminController::class, 'saveAnswer']);
        });
    });

});
