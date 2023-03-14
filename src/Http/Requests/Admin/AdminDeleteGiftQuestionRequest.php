<?php

namespace EscolaLms\TopicTypeGift\Http\Requests\Admin;

use EscolaLms\Courses\Models\Topic;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AdminDeleteGiftQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('delete', $this->getTopic());
    }

    public function rules(): array
    {
        return [];
    }

    public function getId(): int
    {
        return $this->route('id');
    }

    public function getTopic(): Topic
    {
        return GiftQuestion::findOrFail($this->getId())->giftQuiz->topic;
    }
}
