<?php

namespace EscolaLms\TopicTypeGift\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;

class GiftQuizFactory extends Factory
{
    protected $model = GiftQuiz::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->text,
        ];
    }
}
