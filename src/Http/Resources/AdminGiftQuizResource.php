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
        ];
    }
}
