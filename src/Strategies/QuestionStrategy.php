<?php

namespace EscolaLms\TopicTypeGift\Strategies;

use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Services\Contracts\GiftQuestionServiceContract;
use EscolaLms\TopicTypeGift\Strategies\Contracts\QuestionStrategyContract;
use Illuminate\Support\Str;

abstract class QuestionStrategy implements QuestionStrategyContract
{
    protected GiftQuestion $questionModel;
    protected GiftQuestionServiceContract $service;
    protected string $questionPlainText;

    public function __construct(GiftQuestion $questionModel)
    {
        $this->questionModel = $questionModel;
        $this->service = app(GiftQuestionServiceContract::class);
        $this->questionPlainText = $this->service->removeComment($this->questionModel->value);
    }

    public function getTitle(): string
    {
        if (Str::containsAll($this->questionPlainText, ['::', '::'])) {
            return Str::between($this->questionPlainText, '::', '::');
        }
        return '';
    }

    public function getQuestionForStudent(): string
    {
        $question = trim(preg_replace('/::.*?::/', '', $this->questionPlainText));
        $replacement = Str::endsWith($question, ['}']) ? '' : ' _____ ';

        return trim(preg_replace('/\s*\{.*?\}\s*/s', $replacement, $question));
    }

    public function getOptions(): array
    {
        return [];
    }

    protected function removeFeedbackFromAnswer(string $answer): string
    {
        return trim(preg_replace('/#.*$/', '', $answer));
    }
}
