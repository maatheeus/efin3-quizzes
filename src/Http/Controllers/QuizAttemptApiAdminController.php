<?php

namespace EscolaLms\TopicTypeGift\Http\Controllers;

use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\TopicTypeGift\Http\Controllers\Swagger\QuizAttemptApiAdminSwagger;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminListQuizAttemptRequest;
use EscolaLms\TopicTypeGift\Http\Requests\Admin\AdminReadQuizAttemptRequest;
use EscolaLms\TopicTypeGift\Http\Resources\QuizAttemptResource;
use EscolaLms\TopicTypeGift\Http\Resources\QuizAttemptSimpleResource;
use EscolaLms\TopicTypeGift\Services\Contracts\QuizAttemptServiceContract;
use Illuminate\Http\JsonResponse;

class QuizAttemptApiAdminController extends EscolaLmsBaseController implements QuizAttemptApiAdminSwagger
{
    private QuizAttemptServiceContract $attemptService;

    public function __construct(QuizAttemptServiceContract $attemptService)
    {
        $this->attemptService = $attemptService;
    }

    public function index(AdminListQuizAttemptRequest $request): JsonResponse
    {
        $result = $this->attemptService->findAll($request->getCriteriaDto(), $request->getPageDto(), auth()->id());

        return $this->sendResponseForResource(QuizAttemptSimpleResource::collection($result));
    }

    public function read(AdminReadQuizAttemptRequest $request): JsonResponse
    {
        return $this->sendResponseForResource(QuizAttemptResource::make($request->getAttempt()));
    }
}
