<?php

namespace EscolaLms\TopicTypeGift\Http\Requests;

use EscolaLms\TopicTypeGift\Dtos\Criteria\PageDto;
use EscolaLms\TopicTypeGift\Dtos\Criteria\QuizAttemptCriteriaDto;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ListQuizAttemptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('listOwn', QuizAttempt::class);
    }

    public function rules(): array
    {
        return [];
    }

    public function getCriteriaDto(): QuizAttemptCriteriaDto
    {
        return QuizAttemptCriteriaDto::instantiateFromRequest($this);
    }

    public function getPageDto(): PageDto
    {
        return PageDto::instantiateFromRequest($this);
    }
}
