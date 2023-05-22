<?php

namespace EscolaLms\TopicTypeGift\Http\Controllers;

use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\TopicTypeGift\Http\Controllers\Swagger\GiftQuizApiAdminSwagger;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminReadGiftQuizRequest;
use EscolaLms\TopicTypeGift\Http\Resources\AdminGiftQuizResource;
use Illuminate\Http\JsonResponse;

class GiftQuizApiAdminController extends EscolaLmsBaseController implements GiftQuizApiAdminSwagger
{
    public function read(AdminReadGiftQuizRequest $request): JsonResponse
    {
        return $this->sendResponseForResource(AdminGiftQuizResource::make($request->getGiftQuiz()), __('Gift Quiz retrieved successfully'));
    }
}
