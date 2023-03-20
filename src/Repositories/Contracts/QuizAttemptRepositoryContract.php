<?php

namespace EscolaLms\TopicTypeGift\Repositories\Contracts;

use EscolaLms\Core\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface QuizAttemptRepositoryContract extends BaseRepositoryContract
{
    public function findByCriteria(array $criteria, int $perPage): LengthAwarePaginator;
}
