<?php

namespace EscolaLms\TopicTypeGift\Repositories;

use EscolaLms\Core\Repositories\BaseRepository;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Repositories\Contracts\QuizAttemptRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuizAttemptRepository extends BaseRepository implements QuizAttemptRepositoryContract
{
    public function model(): string
    {
        return QuizAttempt::class;
    }

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function findByCriteria(array $criteria, int $perPage): LengthAwarePaginator
    {
        return $this->queryWithAppliedCriteria($criteria)
            ->paginate($perPage);
    }
}
