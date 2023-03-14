<?php

namespace EscolaLms\TopicTypeGift\Http\Requests\Admin;

use Illuminate\Support\Facades\Gate;

class AdminCreateGiftQuestionRequest extends AdminGiftQuestionRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->getTopic());
    }
}
