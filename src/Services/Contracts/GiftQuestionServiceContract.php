<?php

namespace EscolaLms\TopicTypeGift\Services\Contracts;

use EscolaLms\TopicTypeGift\Dtos\GiftQuestionDto;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;

interface GiftQuestionServiceContract
{
    public function create(GiftQuestionDto $dto): GiftQuestion;
    public function update(GiftQuestionDto $dto, int $id): GiftQuestion;
    public function delete(int $id): void;
}
