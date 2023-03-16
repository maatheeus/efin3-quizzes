<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Strategies\GiftQuestionStrategyFactory;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GiftQuestion
 */
class GiftQuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        $strategy = GiftQuestionStrategyFactory::create($this->resource);

        return [
            'id' => $this->id,
            'type' => $this->type,
            'score' => $this->score,
            'title' => $strategy->getTitle(),
            'question' => $strategy->getQuestionForStudent(),
            'options' => $strategy->getOptions(),
        ];
    }
}
