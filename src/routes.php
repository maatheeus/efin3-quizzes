<?php

use EscolaLms\TopicTypeGift\Http\Controllers\GiftQuestionApiAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['auth:api'])->group(function () {
    Route::prefix('admin/gift-questions')->group(function () {
        Route::post(null, [GiftQuestionApiAdminController::class, 'create']);
        Route::delete('{id}', [GiftQuestionApiAdminController::class, 'delete']);
        Route::put('{id}', [GiftQuestionApiAdminController::class, 'update']);
    });
});
