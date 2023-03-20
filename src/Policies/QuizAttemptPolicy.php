<?php

namespace EscolaLms\TopicTypeGift\Policies;

use EscolaLms\Auth\Models\User;
use EscolaLms\TopicTypeGift\Enum\TopicTypeGiftProjectPermissionEnum;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Carbon;

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

    public function addAnswerOwn(User $user, QuizAttempt $attempt): bool
    {
        return $this->readOwn($user, $attempt)
            && ($attempt->end_at === null || $attempt->end_at > Carbon::now());
    }

    public function read(User $user, QuizAttempt $attempt): bool
    {
        return $user->can(TopicTypeGiftProjectPermissionEnum::READ_QUIZ_ATTEMPT);
    }

    public function list(User $user): bool
    {
        return $user->can(TopicTypeGiftProjectPermissionEnum::LIST_QUIZ_ATTEMPT);
    }
}
