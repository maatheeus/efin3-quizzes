<?php

namespace EscolaLms\TopicTypeGift\Services\Contracts;

use EscolaLms\TopicTypeGift\Dtos\SaveAttemptAnswerDto;
use EscolaLms\TopicTypeGift\Models\AttemptAnswer;

interface AttemptAnswerServiceContract
{
    public function saveAnswer(SaveAttemptAnswerDto $dto): AttemptAnswer;
}
