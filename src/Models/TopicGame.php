<?php

namespace Efin3\Quizzes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use EscolaLms\TopicTypes\Models\TopicContent\AbstractTopicContent;
use Illuminate\Database\Eloquent\Model;
use EscolaLms\TopicTypeGift\Database\Factories\GiftQuizFactory;

class TopicGame extends AbstractTopicContent
{
    use HasFactory;

    public $cacheFor = null;

    protected $fillable = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    public static function rules(): array
    {
        return [];
    }


    public function getMorphClass()
    {
        return self::class;
    }
}
