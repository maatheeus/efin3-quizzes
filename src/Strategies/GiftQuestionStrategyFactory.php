<?php

namespace EscolaLms\TopicTypeGift\Strategies;

use EscolaLms\TopicTypeGift\Enum\QuestionTypeEnum;
use EscolaLms\TopicTypeGift\Exceptions\UnknownGiftTypeException;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Strategies\Contracts\QuestionStrategyContract;

final class GiftQuestionStrategyFactory
{
    /**
     * @throws UnknownGiftTypeException
     */
    public static function create(GiftQuestion $question): QuestionStrategyContract
    {
        switch ($question->type) {
            case QuestionTypeEnum::MULTIPLE_CHOICE:
                return new MultipleChoiceQuestionStrategy($question);
            case QuestionTypeEnum::MULTIPLE_CHOICE_WITH_MULTIPLE_RIGHT_ANSWERS:
                return new MultipleChoiceWithMultipleAnswersQuestionStrategy($question);
            case QuestionTypeEnum::TRUE_FALSE:
                return new TrueFalseQuestionStrategy($question);
            case QuestionTypeEnum::SHORT_ANSWERS:
                return new ShortAnswerQuestionStrategy($question);
            case QuestionTypeEnum::MATCHING:
                return new MatchingQuestionStrategy($question);
            case QuestionTypeEnum::NUMERICAL_QUESTION:
                return new NumericalQuestionStrategy($question);
            case QuestionTypeEnum::ESSAY:
                return new EssayQuestionStrategy($question);
            case QuestionTypeEnum::DESCRIPTION:
                return new DescriptionQuestionStrategy($question);
            default:
                throw new UnknownGiftTypeException($question->type);
        }
    }
}
