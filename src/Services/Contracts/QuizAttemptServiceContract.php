<?php

namespace EscolaLms\TopicTypeGift\Services\Contracts;

use EscolaLms\TopicTypeGift\Dtos\Criteria\PageDto;
use EscolaLms\TopicTypeGift\Dtos\Criteria\QuizAttemptCriteriaDto;
use EscolaLms\TopicTypeGift\Dtos\QuizAttemptDto;
use EscolaLms\TopicTypeGift\Exceptions\TooManyAttemptsException;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface QuizAttemptServiceContract
{
    /**
     * @throws TooManyAttemptsException
     */
    public function getActive(QuizAttemptDto $dto): QuizAttempt;
    public function findByUser(QuizAttemptCriteriaDto $criteriaDto, PageDto $paginationDto, int $userId): LengthAwarePaginator;
    public function findAll(QuizAttemptCriteriaDto $criteriaDto, PageDto $paginationDto): LengthAwarePaginator;
    public function findById(int $id): QuizAttempt;
}
