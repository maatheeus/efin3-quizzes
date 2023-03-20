<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\AttemptAnswer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AttemptAnswer
 */
class AttemptAnswerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getKey(),
            'topic_gift_question_id' => $this->topic_gift_question_id,
            'answer' => $this->answer,
            'score' => $this->score,
            'feedback' => $this->feedback,
        ];
    }
}
