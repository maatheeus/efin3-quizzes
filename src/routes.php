<?php

use EscolaLms\TopicTypeGift\Http\Controllers\GiftQuestionApiAdminController;
use EscolaLms\TopicTypeGift\Http\Controllers\QuizAttemptApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['auth:api'])->group(function () {
    Route::prefix('admin/gift-questions')->group(function () {
        Route::post(null, [GiftQuestionApiAdminController::class, 'create']);
        Route::delete('{id}', [GiftQuestionApiAdminController::class, 'delete']);
        Route::put('{id}', [GiftQuestionApiAdminController::class, 'update']);
    });

    Route::prefix('quiz-attempts')->group(function () {
        Route::get(null, [QuizAttemptApiController::class, 'index']);
        Route::post(null, [QuizAttemptApiController::class, 'create']);
        Route::get('{id}', [QuizAttemptApiController::class, 'read']);
    });
});
