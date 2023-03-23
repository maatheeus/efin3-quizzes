<?php

namespace EscolaLms\TopicTypeGift\Jobs;

use EscolaLms\TopicTypeGift\Events\QuizAttemptFinishedEvent;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Repositories\Contracts\QuizAttemptRepositoryContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class MarkAttemptAsEnded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $quizAttemptId;

    public function __construct(int $quizAttemptId)
    {
        $this->quizAttemptId = $quizAttemptId;
    }

    public function handle(QuizAttemptRepositoryContract $attemptRepository): void
    {
        /** @var ?QuizAttempt $result */
        $result = $attemptRepository->find($this->quizAttemptId);

        if (!$result || $result->isEnded()) {
            return;
        }

        $attemptRepository->update(['end_at' => Carbon::now()], $this->quizAttemptId);
        event(new QuizAttemptFinishedEvent($result->user, $result));
    }
}
