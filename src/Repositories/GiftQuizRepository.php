<?php

namespace EscolaLms\TopicTypeGift\Repositories;

use EscolaLms\Core\Repositories\BaseRepository;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Repositories\Contracts\GiftQuizRepositoryContract;

class GiftQuizRepository extends BaseRepository implements GiftQuizRepositoryContract
{
    public function model(): string
    {
        return GiftQuiz::class;
    }

    public function getFieldsSearchable(): array
    {
        return [];
    }
}
