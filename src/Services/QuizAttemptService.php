<?php

namespace EscolaLms\TopicTypeGift\Services;

use EscolaLms\Core\Repositories\Criteria\Primitives\EqualCriterion;
use EscolaLms\TopicTypeGift\Dtos\Criteria\PageDto;
use EscolaLms\TopicTypeGift\Dtos\Criteria\QuizAttemptCriteriaDto;
use EscolaLms\TopicTypeGift\Dtos\QuizAttemptDto;
use EscolaLms\TopicTypeGift\Exceptions\TooManyAttemptsException;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Repositories\Contracts\QuizAttemptRepositoryContract;
use EscolaLms\TopicTypeGift\Services\Contracts\QuizAttemptServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class QuizAttemptService implements QuizAttemptServiceContract
{
    private QuizAttemptRepositoryContract $attemptRepository;

    public function __construct(QuizAttemptRepositoryContract $attemptRepository)
    {
        $this->attemptRepository = $attemptRepository;
    }

    public function findAll(QuizAttemptCriteriaDto $criteriaDto, PageDto $paginationDto): LengthAwarePaginator
    {
        return $this->attemptRepository->findByCriteria($criteriaDto->toArray(), $paginationDto->getPerPage());
    }

    public function findByUser(QuizAttemptCriteriaDto $criteriaDto, PageDto $paginationDto, int $userId): LengthAwarePaginator
    {
        $criteria = $criteriaDto->toArray();
        $criteria[] = new EqualCriterion('user_id', $userId);

        return $this->attemptRepository->findByCriteria($criteria, $paginationDto->getPerPage());
    }

    /**
     * @throws TooManyAttemptsException
     */
    public function create(QuizAttemptDto $dto): QuizAttempt
    {
        /** @var GiftQuiz $quiz */
        $quiz = GiftQuiz::findOrFail($dto->getQuizId());

        $userAttempt = $this->attemptRepository->allQuery([
            'user_id' => $dto->getUserId(),
            'topic_gift_quiz_id' => $dto->getQuizId()
        ]);

        if (is_numeric($quiz->max_attempts) && $userAttempt->count() >= $quiz->max_attempts) {
            throw new TooManyAttemptsException();
        }

        /** @var QuizAttempt */
        return $this->attemptRepository->create(array_merge($dto->toArray(), [
            'end_at' => $quiz->max_execution_time ? Carbon::now()->addMinutes($quiz->max_execution_time) : null,
        ]));
    }
}
