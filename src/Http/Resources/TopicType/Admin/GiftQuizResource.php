<?php

namespace Efin3\Quizzes\Http\Resources\TopicType\Admin;

use EscolaLms\Courses\Http\Resources\TopicType\Contracts\TopicTypeResourceContract;
use EscolaLms\TopicTypeGift\Http\Resources\AdminGiftQuestionResource;
use fin3\Quizzes\Models\TopicQuiz;
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
            'max_attempts' => $request->input('max_attempts'),
            'max_execution_time' => $request->input('max_execution_time'),
            'min_pass_score' => $request->input('min_pass_score'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'value'     => $request->input('value'),
            'questions' => []
        ];
    }
}
