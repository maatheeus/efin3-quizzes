<?php

namespace EscolaLms\TopicTypeGift\Policies;

use EscolaLms\Auth\Models\User;
use EscolaLms\TopicTypeGift\Enum\TopicTypeGiftProjectPermissionEnum;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizAttemptPolicy
{
    use HandlesAuthorization;

    public function createOwn(User $user): bool
    {
        return $user->can(TopicTypeGiftProjectPermissionEnum::CREATE_OWN_QUIZ_ATTEMPT);
    }

    public function readOwn(User $user, QuizAttempt $attempt): bool
    {
        return $user->can(TopicTypeGiftProjectPermissionEnum::READ_OWN_QUIZ_ATTEMPT)
            && $attempt->user_id === $user->getKey();
    }

    public function listOwn(User $user): bool
    {
        return $user->can(TopicTypeGiftProjectPermissionEnum::LIST_OWN_QUIZ_ATTEMPT);
    }
}
