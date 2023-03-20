<?php

namespace EscolaLms\TopicTypeGift\Http\Requests;

use EscolaLms\Courses\Models\Topic;
use EscolaLms\TopicTypeGift\Dtos\QuizAttemptDto;
use EscolaLms\TopicTypeGift\Enum\TopicTypeGiftProjectPermissionEnum;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Schema(
 *      schema="CreateQuizAttemptRequest",
 *      required={"topic_gift_quiz_id"},
 *      @OA\Property(
 *          property="topic_gift_quiz_id",
 *          description="topic_gift_quiz_id",
 *          type="number"
 *      )
 * )
 *
 */
class CreateQuizAttemptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('createOwn', QuizAttempt::class)
            && Gate::allows('attend', $this->getTopic());
    }

    public function rules(): array
    {
        return [
            'topic_gift_quiz_id' => ['required', 'integer', 'exists:topic_gift_quizzes,id'],
        ];
    }

    public function getQuizAttemptDto(): QuizAttemptDto
    {
        return QuizAttemptDto::instantiateFromRequest($this);
    }

    public function getTopic(): Topic
    {
        return GiftQuiz::findOrFail($this->get('topic_gift_quiz_id'))->topic;
    }
}
