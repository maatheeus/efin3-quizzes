<?php

namespace EscolaLms\TopicTypeGift\Dtos;

use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use Illuminate\Http\Request;

class GiftQuestionDto implements DtoContract, InstantiateFromRequest
{
    private int $giftQuizId;
    private string $value;
    private int $score;

    public function __construct(int $giftQuizId, string $value, int $score)
    {
        $this->giftQuizId = $giftQuizId;
        $this->value = $value;
        $this->score = $score;
    }

    public function getGiftQuizId(): int
    {
        return $this->giftQuizId;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function toArray(): array
    {
        return [
            'topic_gift_quiz_id' => $this->getGiftQuizId(),
            'value' => $this->getValue(),
            'score' => $this->getScore(),
        ];
    }

    public static function instantiateFromRequest(Request $request): self
    {
        return new static(
            $request->input('topic_gift_quiz_id'),
            $request->input('value'),
            $request->input('score')
        );
    }
}
