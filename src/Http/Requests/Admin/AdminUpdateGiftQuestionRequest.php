<?php

namespace EscolaLms\TopicTypeGift\Http\Requests\Admin;

use Illuminate\Support\Facades\Gate;

class AdminUpdateGiftQuestionRequest extends AdminGiftQuestionRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->getTopic());
    }

    public function getId(): int
    {
        return $this->route('id');
    }
}
