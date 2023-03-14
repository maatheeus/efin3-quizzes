<?php

namespace EscolaLms\TopicTypeGift\Services;

use EscolaLms\TopicTypeGift\Dtos\GiftQuestionDto;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Repositories\Contracts\GiftQuestionRepositoryContract;
use EscolaLms\TopicTypeGift\Services\Contracts\GiftQuestionServiceContract;

class GiftQuestionService implements GiftQuestionServiceContract
{
    private GiftQuestionRepositoryContract $giftQuestionRepository;

    public function __construct(GiftQuestionRepositoryContract $giftQuestionRepository)
    {
        $this->giftQuestionRepository = $giftQuestionRepository;
    }

    public function create(GiftQuestionDto $dto): GiftQuestion
    {
        /** @var GiftQuestion */
        return $this->giftQuestionRepository->create($dto->toArray());
    }

    public function update(GiftQuestionDto $dto, int $id): GiftQuestion
    {
        /** @var GiftQuestion */
        return $this->giftQuestionRepository->update($dto->toArray(), $id);
    }

    public function delete(int $id): void
    {
        $this->giftQuestionRepository->delete($id);
    }
}
