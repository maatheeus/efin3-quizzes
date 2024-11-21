<?php

namespace Efin3\Quizzes\Http\Resources\TopicType\Admin;

use EscolaLms\Courses\Http\Resources\TopicType\Contracts\TopicTypeResourceContract;
use EscolaLms\TopicTypeGift\Http\Resources\AdminGiftQuestionResource;
use Efin3\Quizzes\Models\TopicQuiz;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TopicQuiz
 */
class GameResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request): array
    {
        return  [
            'id' => $this->id,
            'game_id' => $this->game_id
        ];
    }
}
