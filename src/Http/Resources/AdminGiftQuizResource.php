<?php

namespace Efin3\Quizzes\Http\Resources;

use Efin3\Quizzes\Models\TopicQuiz;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TopicQuiz
 */
class AdminGiftQuizResource extends JsonResource
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
