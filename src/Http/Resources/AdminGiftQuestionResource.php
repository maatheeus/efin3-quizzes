<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use Illuminate\Http\Resources\Json\JsonResource;


class AdminGiftQuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'alternatives' => $this->alternatives
        ];
    }
}
