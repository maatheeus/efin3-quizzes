<?php

namespace Efin3\Quizzes\Http\Resources\TopicType\Client;

use EscolaLms\Courses\Http\Resources\TopicType\Contracts\TopicTypeResourceContract;
use Efin3\Quizzes\Models\TopicQuiz;
use Efin3\Quizzes\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TopicQuiz
 */
class GiftQuizResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'max_attempts' => $this->max_attempts,
            'max_execution_time' => $this->max_execution_time,
            'min_pass_score' => $this->min_pass_score,
            'questions' => $this->questions->map(function($question) use ($request) {
                $checkUserResponse = Answer::where('question_id', $question->id)->where('user_id', $request->user()->id)->first();

                if(!$checkUserResponse)
                    $question->alternatives->makeHidden('is_correct');
                    $question->alternatives->makeHidden('resolution');
                    $question->makeHidden('resolution');

                

                return [
                    'id' => $question->id,
                    'type' => 'multiple_choice',
                    'question_text' => $question->question_text,
                    'created_at' => $question->created_at,
                    'updated_at' => $question->updated_at,
                    'marked_user' => $checkUserResponse ? $checkUserResponse->alternative_id : null,
                    'alternatives' => $question->alternatives
                ];
            })
        ];
    }
}
