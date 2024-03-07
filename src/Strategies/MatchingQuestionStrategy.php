<?php

namespace EscolaLms\TopicTypeGift\Strategies;

use EscolaLms\TopicTypeGift\Dtos\CheckAnswerDto;
use EscolaLms\TopicTypeGift\Enum\AnswerKeyEnum;
use Illuminate\Support\Collection;

class MatchingQuestionStrategy extends QuestionStrategy
{
    public function getOptions(): array
    {
        $answers = $this->getCorrectAnswers();

        return [
            'sub_questions' => $answers
                ->map(fn($answer) => $answer[0])
                ->shuffle()
                ->toArray(),

            'sub_answers' => $answers
                ->map(fn($answer) => $answer[1])
                ->shuffle()
                ->toArray(),
        ];
    }

    public function checkAnswer(array $answer): CheckAnswerDto
    {
        $correctAnswers = $this->getCorrectAnswers();
        $answer = $answer[$this->getAnswerKey()];
        $result = new CheckAnswerDto();

        foreach ($correctAnswers as $correctAnswer) {
            if ($answer[$correctAnswer[0]] != $correctAnswer[1])
                return $result->setScore(0);
        }

        return $result->setScore($this->questionModel->score);
    }

    private function getCorrectAnswers(): Collection
    {
        $escapedQuestion = $this->escapedcharPre($this->questionPlainText);
        $answerBlock = $this->service->getAnswerFromQuestion($escapedQuestion);
        $answers = preg_split('/\s*=\s*/', $answerBlock, -1, PREG_SPLIT_NO_EMPTY);

        return collect($answers)
            ->map(fn($answer) => $this->escapedcharPost($answer))
            ->map(fn($answer) => $this->removeFeedbackFromAnswer($answer))
            ->map(fn($answer) => explode('->', $answer))
            ->map(fn($answer) => [trim($answer[0]), trim($answer[1])]);
    }

    public function getAnswerKey(): string
    {
        return AnswerKeyEnum::MATCHING;
    }
}
