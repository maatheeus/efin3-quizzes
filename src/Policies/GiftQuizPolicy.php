<?php

namespace EscolaLms\TopicTypeGift\Policies;

use EscolaLms\Auth\Models\User;
use EscolaLms\TopicTypeGift\Enum\TopicTypeGiftProjectPermissionEnum;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Carbon;

class GiftQuizPolicy
{
    use HandlesAuthorization;

    public function read(User $user, GiftQuiz $giftQuiz): bool
    {
        return $user->can(TopicTypeGiftProjectPermissionEnum::READ_GIFT_QUIZ);
    }

}
