<?php

namespace EscolaLms\TopicTypeGift\Strategies\Contracts;

interface QuestionStrategyContract
{
    public function getTitle(): string;
    public function getQuestionForStudent(): string;
    public function getOptions(): array;
}
