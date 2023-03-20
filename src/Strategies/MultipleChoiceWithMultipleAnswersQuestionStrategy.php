<?php

namespace EscolaLms\TopicTypeGift\Strategies;

use EscolaLms\TopicTypeGift\Dtos\CheckAnswerDto;
use EscolaLms\TopicTypeGift\Enum\AnswerKeyEnum;
use Illuminate\Support\Str;

class MultipleChoiceWithMultipleAnswersQuestionStrategy extends QuestionStrategy
{
    public function getOptions(): array
    {
        $answerBlock = $this->service->getAnswerFromQuestion($this->questionPlainText);
        $answers = preg_split('/\s*~%.*?%\s*/', $answerBlock, -1, PREG_SPLIT_NO_EMPTY);

        return [
            'answers' => collect($answers)
                ->map(fn($answer) => $this->removeFeedbackFromAnswer($answer))
                ->toArray(),
        ];
    }

    public function checkAnswer(array $answer): CheckAnswerDto
    {
        $answerBlock = $this->service->getAnswerFromQuestion($this->questionPlainText);
        $allAnswers = preg_split('/\s*~\s*/', $answerBlock, -1, PREG_SPLIT_NO_EMPTY);
        $allAnswers = collect($allAnswers)->map(function ($answer) {
            return [
                'value' => trim(Str::beforeLast(Str::afterLast($answer, '%'), '#')),
                'feedback' => Str::contains($answer, '#') ? Str::after($answer, '#') : '',
                'percent' => (float) Str::between($answer, '%', '%'),
            ];
        });

        $percent = 0;
        $result = new CheckAnswerDto();

        foreach ($answer[$this->getAnswerKey()] as $item) {
            $found = $allAnswers->firstWhere('value', $item);
            if ($found) {
                $percent += $found['percent'];
                $found['feedback'] ?? $result->addFeedback($item . ' -> ' . $found['feedback']);
            }
        }

        $result->setScore($this->questionModel->score * $percent * 0.01);
        return $result;
    }

    public function getAnswerKey(): string
    {
        return AnswerKeyEnum::MULTIPLE;
    }
}
