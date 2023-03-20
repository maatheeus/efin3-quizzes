<?php

namespace EscolaLms\TopicTypeGift\Strategies;

use EscolaLms\TopicTypeGift\Dtos\CheckAnswerDto;
use EscolaLms\TopicTypeGift\Enum\AnswerKeyEnum;
use Illuminate\Support\Str;

class MultipleChoiceQuestionStrategy extends QuestionStrategy
{
    public function getOptions(): array
    {
        $answerBlock = $this->service->getAnswerFromQuestion($this->questionPlainText);
        $answers = preg_split('/\s*[=~]\s*/', $answerBlock, -1, PREG_SPLIT_NO_EMPTY);

        return [
            'answers' => collect($answers)
                ->map(fn($answer) => $this->removeFeedbackFromAnswer($answer))->toArray(),
        ];
    }

    public function checkAnswer(array $answer): CheckAnswerDto
    {
        $result = new CheckAnswerDto();

        if ($this->getCorrectAnswer() === $answer[$this->getAnswerKey()]) {
            $result->setScore($this->questionModel->score);
        }

        $result->setFeedback($this->getFeedbackByAnswer($answer[$this->getAnswerKey()]));

        return $result;
    }

    public function getCorrectAnswer(): string
    {
        $answerBlock = $this->service->getAnswerFromQuestion($this->questionPlainText);

        if (preg_match('/=([^~]*)/', $answerBlock, $matches)) {
            return $this->removeFeedbackFromAnswer($matches[1]);
        }

        return '';
    }

    public function getFeedbackByAnswer(string $answer): ?string
    {
        $answerBlock = $this->service->getAnswerFromQuestion($this->questionPlainText);

        $pattern = "/$answer(.*?)(~|$)/";
        if (preg_match($pattern, $answerBlock, $matches)) {
            return trim(Str::replace('#', ' ', $matches[1]));
        }

        return null;
    }

    public function getAnswerKey(): string
    {
        return AnswerKeyEnum::TEXT;
    }
}
