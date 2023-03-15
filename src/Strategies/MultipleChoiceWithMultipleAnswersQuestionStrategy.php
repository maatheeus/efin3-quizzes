<?php

namespace EscolaLms\TopicTypeGift\Strategies;

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
}
