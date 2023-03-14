<?php

namespace EscolaLms\TopicTypeGift\Dtos;

use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use Illuminate\Http\Request;

class GiftQuestionDto implements DtoContract, InstantiateFromRequest
{
    private string $giftQuizId;
    private string $value;

    public function __construct(string $giftQuizId, string $value)
    {
        $this->giftQuizId = $giftQuizId;
        $this->value = $value;
    }

    public function getGiftQuizId(): string
    {
        return $this->giftQuizId;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'topic_gift_quiz_id' => $this->getGiftQuizId(),
            'value' => $this->getValue(),
        ];
    }

    public static function instantiateFromRequest(Request $request): self
    {
        return new static(
            $request->input('topic_gift_quiz_id'),
            $request->input('value')
        );
    }
}
