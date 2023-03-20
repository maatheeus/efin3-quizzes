<?php

namespace EscolaLms\TopicTypeGift\Http\Controllers;

use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\TopicTypeGift\Http\Controllers\Swagger\QuizAttemptApiSwagger;
use EscolaLms\TopicTypeGift\Http\Requests\CreateQuizAttemptRequest;
use EscolaLms\TopicTypeGift\Http\Requests\ListQuizAttemptRequest;
use EscolaLms\TopicTypeGift\Http\Requests\ReadQuizAttemptRequest;
use EscolaLms\TopicTypeGift\Http\Resources\QuizAttemptResource;
use EscolaLms\TopicTypeGift\Http\Resources\QuizAttemptSimpleResource;
use EscolaLms\TopicTypeGift\Services\Contracts\QuizAttemptServiceContract;
use Illuminate\Http\JsonResponse;

class QuizAttemptApiController extends EscolaLmsBaseController implements QuizAttemptApiSwagger
{
    private QuizAttemptServiceContract $attemptService;

    public function __construct(QuizAttemptServiceContract $attemptService)
    {
        $this->attemptService = $attemptService;
    }

    public function index(ListQuizAttemptRequest $request): JsonResponse
    {
        $result = $this->attemptService->findByUser($request->getCriteriaDto(), $request->getPageDto(), auth()->id());

        return $this->sendResponseForResource(QuizAttemptSimpleResource::collection($result));
    }

    public function read(ReadQuizAttemptRequest $request): JsonResponse
    {
        return $this->sendResponseForResource(QuizAttemptResource::make($request->getAttempt()));
    }

    public function create(CreateQuizAttemptRequest $request): JsonResponse
    {
        $result = $this->attemptService->create($request->getQuizAttemptDto());

        return $this->sendResponseForResource(QuizAttemptSimpleResource::make($result), __('Quiz attempt created successfully.'));
    }
}
