<?php

namespace EscolaLms\TopicTypeGift\Services;

use EscolaLms\Core\Repositories\Criteria\Primitives\EqualCriterion;
use EscolaLms\TopicTypeGift\Dtos\Criteria\PageDto;
use EscolaLms\TopicTypeGift\Dtos\Criteria\QuizAttemptCriteriaDto;
use EscolaLms\TopicTypeGift\Dtos\QuizAttemptDto;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Repositories\Contracts\QuizAttemptRepositoryContract;
use EscolaLms\TopicTypeGift\Services\Contracts\QuizAttemptServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function create(QuizAttemptDto $dto): QuizAttempt
    {
        // TODO check if the user can create a new attempt and set end time

        /** @var QuizAttempt */
        return $this->attemptRepository->create($dto->toArray());
    }
}
