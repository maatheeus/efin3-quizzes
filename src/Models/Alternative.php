<?php

namespace Efin3\Quizzes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $table = 'topic_quizzes_alternatives'; 
    use HasFactory;

    protected $fillable = [
        'question_id',
        'alternative_text',
        'is_correct',
        'resolution',
    ];

    /**
     * Get the question that owns the alternative.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
