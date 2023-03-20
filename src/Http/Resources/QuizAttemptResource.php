<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin QuizAttempt
 */
class QuizAttemptResource extends QuizAttemptSimpleResource
{
    public function toArray($request): array
    {
        // todo
        return parent::toArray($request);
    }
}
