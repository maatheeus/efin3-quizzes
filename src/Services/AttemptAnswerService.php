<?php

namespace EscolaLms\TopicTypeGift\Services;

use EscolaLms\TopicTypeGift\Dtos\SaveAttemptAnswerDto;
use EscolaLms\TopicTypeGift\Models\AttemptAnswer;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Repositories\AttemptAnswerRepository;
use EscolaLms\TopicTypeGift\Repositories\Contracts\GiftQuestionRepositoryContract;
use EscolaLms\TopicTypeGift\Services\Contracts\AttemptAnswerServiceContract;
use EscolaLms\TopicTypeGift\Strategies\GiftQuestionStrategyFactory;

class AttemptAnswerService implements AttemptAnswerServiceContract
{
    public AttemptAnswerRepository $answerRepository;
    public GiftQuestionRepositoryContract $questionRepository;

    public function __construct(
        AttemptAnswerRepository $answerRepository,
        GiftQuestionRepositoryContract $questionRepository
    ) {
        $this->answerRepository = $answerRepository;
        $this->questionRepository = $questionRepository;
    }

    public function saveAnswer(SaveAttemptAnswerDto $dto): AttemptAnswer
    {
        /** @var GiftQuestion $question */
        $question = $this->questionRepository->find($dto->getQuestionId());
        $strategy = GiftQuestionStrategyFactory::create($question);

        $result = $strategy->checkAnswer($dto->getAnswer());

        return $this->answerRepository->updateOrCreate($dto->toArray(), [
            'answer' => $dto->getAnswer(),
            'feedback' => $result->getFeedback(),
            'score' => $result->getScore(),
        ]);
    }
}
