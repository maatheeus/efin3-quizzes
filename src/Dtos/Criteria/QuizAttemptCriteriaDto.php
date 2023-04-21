<?php

namespace EscolaLms\TopicTypeGift\Dtos\Criteria;

use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use EscolaLms\Core\Dtos\CriteriaDto as BaseCriteriaDto;
use EscolaLms\Core\Repositories\Criteria\Primitives\DateCriterion;
use EscolaLms\Core\Repositories\Criteria\Primitives\EqualCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use EscolaLms\Courses\Repositories\Criteria\Primitives\OrderCriterion;

class QuizAttemptCriteriaDto extends BaseCriteriaDto implements DtoContract, InstantiateFromRequest
{
    public static function instantiateFromRequest(Request $request): self
    {
        $criteria = new Collection();

        if ($request->get('user_id')) {
            $criteria->push(new EqualCriterion('user_id', $request->get('user_id')));
        }

        if ($request->get('topic_gift_quiz_id')) {
            $criteria->push(new EqualCriterion('topic_gift_quiz_id', $request->get('topic_gift_quiz_id')));
        }

        if ($request->get('date_from')) {
            $criteria->push(new DateCriterion('started_at', $request->get('date_from'), '>='));
        }

        if ($request->get('date_to')) {
            $criteria->push(new DateCriterion('end_at', $request->get('date_to'), '<='));
        }

        $criteria->push(new OrderCriterion($request->get('order_by') ?? 'id', $request->get('order') ?? 'desc'));

        return new static($criteria);
    }
}
