<?php

namespace Efin3\Quizzes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use EscolaLms\TopicTypes\Models\TopicContent\AbstractTopicContent;
use Illuminate\Database\Eloquent\Model;
use EscolaLms\TopicTypeGift\Database\Factories\GiftQuizFactory;

class TopicQuiz extends AbstractTopicContent
{
    use HasFactory;

    public $cacheFor = null;

    protected $fillable = [
        'id',
        'max_attempts',
        'max_execution_time',
        'min_pass_score'
    ];

    protected $casts = [
        'id' => 'integer',
        'max_attempts' => 'integer',
        'max_execution_time' => 'integer',
        'min_pass_score' => 'double',
    ];

    public static function rules(): array
    {
        return [
            'max_attempts' => ['nullable', 'integer', 'min:1'],
            'max_execution_time' => ['nullable', 'integer', 'min:1'],
            'min_pass_score' => ['nullable', 'numeric', 'min:0'],
        ];
    }


    /**
     * Get the questions for the quiz.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'topic_quiz_id');
    }

    #protected static function newFactory(): GiftQuizFactory
    #{
    #    return GiftQuizFactory::new();
    #}

    public function getMorphClass()
    {
        return self::class;
    }
}
