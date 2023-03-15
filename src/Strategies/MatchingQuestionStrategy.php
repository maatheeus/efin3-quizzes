<?php

namespace EscolaLms\TopicTypeGift\Strategies;

class MatchingQuestionStrategy extends QuestionStrategy
{
    public function getOptions(): array
    {
        $answerBlock = $this->service->getAnswerFromQuestion($this->questionPlainText);
        $answers = preg_split('/\s*=\s*/', $answerBlock, -1, PREG_SPLIT_NO_EMPTY);
        $answers = collect($answers)
            ->map(fn($answer) => $this->removeFeedbackFromAnswer($answer))
            ->map(fn($answer) => explode('->', $answer));

        return [
            'sub_questions' => $answers
                ->map(fn($answer) => trim($answer[0]))
                ->shuffle()
                ->toArray(),

            'sub_answers' => $answers
                ->map(fn($answer) => trim($answer[1]))
                ->shuffle()
                ->toArray(),
        ];
    }
}
