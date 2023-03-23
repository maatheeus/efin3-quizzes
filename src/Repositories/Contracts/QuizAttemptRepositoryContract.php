<?php

namespace EscolaLms\TopicTypeGift\Repositories\Contracts;

use EscolaLms\Core\Repositories\Contracts\BaseRepositoryContract;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

interface QuizAttemptRepositoryContract extends BaseRepositoryContract
{
    public function findByCriteria(array $criteria, int $perPage): LengthAwarePaginator;
    public function queryByUserIdAndQuizId(int $userId, int $quizId): Builder;
    public function findActive(int $userId, int $quizId): ?QuizAttempt;
}
