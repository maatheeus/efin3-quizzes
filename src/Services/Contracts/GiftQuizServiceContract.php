<?php

namespace EscolaLms\TopicTypeGift\Services\Contracts;

use EscolaLms\TopicTypeGift\Dtos\QuizDto;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;

interface GiftQuizServiceContract
{
    public function update(int $id, QuizDto $dto): GiftQuiz;
}
