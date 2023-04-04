<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      schema="QuizAttemptResource",
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="topic_gift_quiz_id",
 *          description="topic_gift_quiz_id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="started_at",
 *          description="started_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="end_at",
 *          description="end_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="is_ended",
 *          description="is_ended",
 *          type="boolean"
 *      ),
 *     @OA\Property(
 *          property="questions",
 *          description="questions",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/GiftQuestionResource")
 *      ),
 *     @OA\Property(
 *          property="answers",
 *          description="answers",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/AttemptAnswerResource")
 *      )
 * )
 *
 */

/**
 * @mixin QuizAttempt
 */
class QuizAttemptResource extends QuizAttemptSimpleResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'questions' => GiftQuestionResource::collection($this->giftQuiz->questions->sortBy('order')),
            'answers' => AttemptAnswerResource::collection($this->answers),
        ]);
    }
}
