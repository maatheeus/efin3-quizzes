<?php

namespace EscolaLms\TopicTypeGift\Models;

use EscolaLms\TopicTypeGift\Database\Factories\QuizAttemptFactory;
use EscolaLms\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * EscolaLms\TopicTypeGift\Models\QuizAttempt
 *
 * @property int $id
 * @property int $topic_gift_quiz_id
 * @property int $user_id
 * @property Carbon $started_at
 * @property Carbon $end_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read GiftQuiz $giftQuiz
 * @property-read AttemptAnswer[]|Collection $answers
 */
class QuizAttempt extends Model
{
    use HasFactory;

    public $table = 'topic_gift_quiz_attempts';

    public $fillable = [
        'topic_gift_quiz_id',
        'user_id',
        'started_at',
        'end_at',
    ];

    public $casts = [
        'started_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function giftQuiz(): BelongsTo
    {
        return $this->belongsTo(GiftQuiz::class, 'topic_gift_quiz_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class, 'topic_gift_quiz_attempt_id');
    }

    protected static function newFactory(): QuizAttemptFactory
    {
        return QuizAttemptFactory::new();
    }
}
