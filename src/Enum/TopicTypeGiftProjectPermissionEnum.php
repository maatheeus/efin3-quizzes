<?php

namespace EscolaLms\TopicTypeGift\Enum;

use EscolaLms\Core\Enums\BasicEnum;

class TopicTypeGiftProjectPermissionEnum extends BasicEnum
{
    public const CREATE_OWN_QUIZ_ATTEMPT = 'quiz-attempt_create-own';
    public const LIST_OWN_QUIZ_ATTEMPT = 'quiz-attempt_list-own';
    public const READ_OWN_QUIZ_ATTEMPT = 'quiz-attempt_read-own';
}
