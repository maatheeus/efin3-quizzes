<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      schema="QuizAttemptSimpleResource",
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
 *          property="questions",
 *          description="questions",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/GiftQuestionResource")
 *      )
 * )
 *
 */

/**
 * @mixin QuizAttempt
 */
class QuizAttemptSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        $maxScore = $this->giftQuiz->questions->sum('score');
        $resultScore = $this->answers->sum('score');

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'topic_gift_quiz_id' => $this->topic_gift_quiz_id,
            'started_at' => $this->started_at,
            'end_at' => $this->end_at,
            'max_score' => $maxScore,
            'result_score' => $resultScore,
            'questions' => GiftQuestionResource::collection($this->giftQuiz->questions->sortBy('id')),
        ];
    }
}
