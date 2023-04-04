<?php

namespace EscolaLms\TopicTypeGift\Http\Controllers;

use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\TopicTypeGift\Http\Controllers\Swagger\GiftQuestionApiAdminSwagger;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminCreateGiftQuestionRequest;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminDeleteGiftQuestionRequest;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminSortGiftQuestionRequest;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminUpdateGiftQuestionRequest;
use EscolaLms\TopicTypeGift\Http\Resources\AdminGiftQuestionResource;
use EscolaLms\TopicTypeGift\Services\Contracts\GiftQuestionServiceContract;
use Illuminate\Http\JsonResponse;

class GiftQuestionApiAdminController extends EscolaLmsBaseController implements GiftQuestionApiAdminSwagger
{
    private GiftQuestionServiceContract $giftQuestionService;

    public function __construct(GiftQuestionServiceContract $giftQuestionService)
    {
        $this->giftQuestionService = $giftQuestionService;
    }

    public function create(AdminCreateGiftQuestionRequest $request): JsonResponse
    {
        $result = $this->giftQuestionService->create($request->getGiftQuestionDto());

        return $this->sendResponseForResource(AdminGiftQuestionResource::make($result), __('Gift question created successfully.'));
    }

    public function update(AdminUpdateGiftQuestionRequest $request): JsonResponse
    {
        $result = $this->giftQuestionService->update($request->getGiftQuestionDto(), $request->getId());

        return $this->sendResponseForResource(AdminGiftQuestionResource::make($result), __('Gift question updated successfully.'));
    }

    public function delete(AdminDeleteGiftQuestionRequest $request): JsonResponse
    {
        $this->giftQuestionService->delete($request->getId());

        return $this->sendSuccess(__('Gift question deleted successfully.'));
    }

    public function sort(AdminSortGiftQuestionRequest $request): JsonResponse
    {
        $this->giftQuestionService->sort($request->toDto());

        return $this->sendSuccess(__('Gift questions sorted successfully.'));
    }
}
