<?php

namespace EscolaLms\TopicTypeGift\Database\Factories;

use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class GiftQuestionFactory extends Factory
{
    protected $model = GiftQuestion::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->randomElement($this->getExamples()),
        ];
    }

    private function getExamples(): array
    {
        return [
            'Who\'s buried in Grant\'s tomb?{~Grant ~Jefferson =no one}',
            'Grant is {~buried =entombed ~living} in Grant\'s tomb.',
            'Grant is buried in Grant\'s tomb.{FALSE}',
            'Who\'s buried in Grant\'s tomb?{=no one =nobody}',
            'When was Ulysses S. Grant born?{#1822:1}',
            'The American holiday of Thanksgiving is celebrated on the {~second ~third =fourth} Thursday of November.',
            'Two plus two equals {=four =4}.',
            'What is the value of pi (to 3 decimal places)? {#3.1415:0.0005}.',
        ];
    }
}
