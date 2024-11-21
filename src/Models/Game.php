<?php

namespace Efin3\Quizzes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games'; 
    use HasFactory;

    protected $fillable = [
        'id',
        'file',
        'name',
    ];
}
