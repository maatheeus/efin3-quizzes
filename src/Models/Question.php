<?php

namespace Efin3\Quizzes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'topic_quizzes_questions'; 
    use HasFactory;

    protected $fillable = [
        'topic_quiz_id',
        'question_text',
    ];

    /**
     * Get the quiz that owns the question.
     */
    public function topicQuiz()
    {
        return $this->belongsTo(TopicQuiz::class, 'topic_quiz_id');
    }

    /**
     * Get the alternatives for the question.
     */
    public function alternatives()
    {
        return $this->hasMany(Alternative::class, 'question_id');
    }
}
