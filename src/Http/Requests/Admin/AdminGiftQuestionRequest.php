<?php

namespace EscolaLms\TopicTypeGift\Http\Requests\Admin;

use EscolaLms\Courses\Models\Topic;
use EscolaLms\TopicTypeGift\Dtos\GiftQuestionDto;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      schema="AdminGiftQuestionRequest",
 *      required={"topic_gift_quiz_id", "value"},
 *      @OA\Property(
 *          property="topic_gift_quiz_id",
 *          description="topic_gift_quiz_id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="value",
 *          type="string"
 *      ),
 * )
 *
 */
class AdminGiftQuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'topic_gift_quiz_id' => ['required', 'integer', 'exists:topic_gift_quizzes,id'],
            'value' => ['required', 'string'],
        ];
    }

    public function getGiftQuestionDto(): GiftQuestionDto
    {
        return GiftQuestionDto::instantiateFromRequest($this);
    }

    public function getTopic(): Topic
    {
        return GiftQuiz::findOrFail($this->get('topic_gift_quiz_id'))->topic;
    }
}
