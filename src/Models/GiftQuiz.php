<?php

namespace EscolaLms\TopicTypeGift\Models;

use EscolaLms\TopicTypeGift\Database\Factories\GiftQuizFactory;
use EscolaLms\TopicTypes\Models\TopicContent\AbstractTopicContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @OA\Schema(
 *      schema="TopicGiftQuiz",
 *      required={"value"},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          @OA\Schema(
 *             type="integer",
 *         )
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="value",
 *          type="string"
 *      )
 * )
 */

/**
 * EscolaLms\TopicTypeGift\Models\GiftQuiz
 *
 * @property int $id
 * @property string $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class GiftQuiz extends AbstractTopicContent
{
    use HasFactory;

    public $table = 'topic_gift_quizzes';

    public static function rules(): array
    {
        return [
            'value' => ['required', 'string'],
        ];
    }

    protected static function newFactory(): GiftQuizFactory
    {
        return GiftQuizFactory::new();
    }

    public function getMorphClass()
    {
        return self::class;
    }
}
