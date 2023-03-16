<?php

namespace EscolaLms\TopicTypeGift\Models;

use EscolaLms\TopicTypeGift\Database\Factories\GiftQuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * EscolaLms\TopicTypeGift\Models\GiftQuestion
 *
 * @property int $id
 * @property int $topic_gift_quiz_id
 * @property string $value
 * @property string $type
 * @property int $score
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read GiftQuiz $giftQuiz
 */
class GiftQuestion extends Model
{
    use HasFactory;

    public $table = 'topic_gift_questions';

    public $fillable = [
        'topic_gift_quiz_id',
        'value',
        'type',
        'score',
    ];

    public function giftQuiz(): BelongsTo
    {
        return $this->belongsTo(GiftQuiz::class, 'topic_gift_quiz_id');
    }

    protected static function newFactory(): GiftQuestionFactory
    {
        return GiftQuestionFactory::new();
    }
}
