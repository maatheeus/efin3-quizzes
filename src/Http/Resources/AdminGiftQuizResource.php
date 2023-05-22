<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      schema="AdminGiftQuizResource",
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="value",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="max_attempts",
 *          description="max attempts",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="max_execution_time",
 *          description="max execution time",
 *          type="number"
 *      ),
 * )
 *
 */

/**
 * @mixin GiftQuiz
 */
class AdminGiftQuizResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'max_attempts' => $this->max_attempts,
            'max_execution_time' => $this->max_execution_time,
        ];
    }
}
