<?php

namespace Efin3\Quizzes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'topic_quizzes_answers'; 
    use HasFactory;

    protected $fillable = [
        'question_id',
        'alternative_id',
        'user_id',
    ];

    /**
     * Get the question that owns the answer.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Get the alternative that is chosen in the answer.
     */
    public function alternative()
    {
        return $this->belongsTo(Alternative::class, 'alternative_id');
    }

    /**
     * Get the user that owns the answer.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
