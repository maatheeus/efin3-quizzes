<?php

namespace Efin3\Quizzes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use EscolaLms\TopicTypes\Models\TopicContent\AbstractTopicContent;
use Illuminate\Database\Eloquent\Model;
use EscolaLms\TopicTypeGift\Database\Factories\GiftQuizFactory;

class TopicQuiz extends AbstractTopicContent
{
    use HasFactory;

    protected $fillable = [
        'id'
    ];

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
