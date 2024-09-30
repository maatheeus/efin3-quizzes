<?php

namespace Efin3\Quizzes\Http\Resources\TopicType\Client;

use EscolaLms\Courses\Http\Resources\TopicType\Contracts\TopicTypeResourceContract;
use Efin3\Quizzes\Models\TopicQuiz;
use Efin3\Quizzes\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TopicQuiz
 */
class GameResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
