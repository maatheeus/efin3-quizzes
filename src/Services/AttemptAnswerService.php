<?php

namespace EscolaLms\TopicTypeGift\Services;

use EscolaLms\TopicTypeGift\Dtos\AdminUpdateAttemptAnswerDto;
use EscolaLms\TopicTypeGift\Dtos\SaveAllAttemptAnswersDto;
use EscolaLms\TopicTypeGift\Dtos\SaveAttemptAnswerDto;
use EscolaLms\TopicTypeGift\Models\AttemptAnswer;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Repositories\AttemptAnswerRepository;
use EscolaLms\TopicTypeGift\Repositories\Contracts\GiftQuestionRepositoryContract;
use EscolaLms\TopicTypeGift\Services\Contracts\AttemptAnswerServiceContract;
use EscolaLms\TopicTypeGift\Strategies\GiftQuestionStrategyFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AttemptAnswerService implements AttemptAnswerServiceContract
{
    private AttemptAnswerRepository $answerRepository;
    private GiftQuestionRepositoryContract $questionRepository;

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

    public function saveAllAnswers(SaveAllAttemptAnswersDto $dto): Collection
    {
        return DB::transaction(function () use ($dto) {
            return collect($dto->getAnswers())->map(function ($answer) use ($dto) {
                return $this->saveAnswer(new SaveAttemptAnswerDto(
                    $dto->getAttemptId(),
                    $answer['topic_gift_question_id'],
                    $answer['answer'],
                ));
            });
        });
    }

    public function adminUpdate(int $id, AdminUpdateAttemptAnswerDto $dto): AttemptAnswer
    {
        /** @var AttemptAnswer */
        return $this->answerRepository->update($dto->toArray(), $id);
    }
}
