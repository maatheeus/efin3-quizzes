<?php

namespace Efin3\Quizzes\Http\Resources\TopicType\Export;

use Efin3\Quizzes\Http\Resources\AdminGiftQuestionResource;
use Efin3\Quizzes\Models\TopicQuiz;
use EscolaLms\TopicTypes\Http\Resources\TopicType\Contacts\TopicTypeResourceContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TopicQuiz
 */
class GiftQuizResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'max_attempts' => $this->max_attempts,
            'max_execution_time' => $this->max_execution_time,
            'min_pass_score' => $this->min_pass_score,
        ];
    }
}
