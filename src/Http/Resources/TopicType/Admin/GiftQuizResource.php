<?php

namespace Efin3\Quizzes\Http\Resources\TopicType\Admin;

use EscolaLms\Courses\Http\Resources\TopicType\Contracts\TopicTypeResourceContract;
use EscolaLms\TopicTypeGift\Http\Resources\AdminGiftQuestionResource;
use Efin3\Quizzes\Models\TopicQuiz;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TopicQuiz
 */
class GiftQuizResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request): array
    {
        return  [
            'id' => $this->id,
            'max_attempts' => $this->max_attempts,
            'max_execution_time' => $this->max_execution_time,
            'min_pass_score' => $this->min_pass_score,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'value' => $this->value,
            'questions' => $this->questions->map(function($question) {
                return [
                    'id' => $question->id,
                    'type' => 'multiple_choice',
                    'question_text' => $question->question_text,
                    'resolution' => $question->resolution,
                    'created_at' => $question->created_at,
                    'updated_at' => $question->updated_at,
                    'alternatives' => $question->alternatives
                ];
            })
        ];
    }
}
