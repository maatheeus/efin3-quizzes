<?php

namespace EscolaLms\TopicTypeGift\Repositories;

use EscolaLms\Core\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
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
        return [
            'user_id',
            'topic_gift_quiz_id',
        ];
    }

    public function findByCriteria(array $criteria, int $perPage): LengthAwarePaginator
    {
        return $this->queryWithAppliedCriteria($criteria)
            ->paginate($perPage);
    }

    public function queryByUserIdAndQuizId(int $userId, int $quizId): Builder
    {
        return $this->allQuery([
            'user_id' => $userId,
            'topic_gift_quiz_id' => $quizId,
        ]);
    }

    public function findActive(int $userId, int $quizId): ?QuizAttempt
    {
        return $this->queryByUserIdAndQuizId($userId, $quizId)->active()->first();
    }
}
