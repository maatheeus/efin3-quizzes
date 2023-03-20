<?php

namespace EscolaLms\TopicTypeGift\Tests\Api;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
use EscolaLms\TopicTypeGift\Models\AttemptAnswer;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Tests\TestCase;

class QuizAttemptReadApiTest extends TestCase
{
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TopicTypeGiftPermissionSeeder::class);

        $this->student = $this->makeStudent();
        $this->attempt = QuizAttempt::factory()
            ->state(['user_id' => $this->student->getKey()])
            ->create();
    }

    public function testQuizAttemptReadUnauthorized(): void
    {
        $this->getJson('api/quiz-attempts/' . $this->attempt->getKey())
            ->assertUnauthorized();
    }

    public function testQuizAttemptReadReadForbidden(): void
    {
        $this->actingAs($this->makeStudent(), 'api')
            ->getJson('api/quiz-attempts/' . $this->attempt->getKey())
            ->assertForbidden();
    }

    public function testQuizAttemptRead(): void
    {
        $this->actingAs($this->student, 'api')
            ->getJson('api/quiz-attempts/' . $this->attempt->getKey())
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'topic_gift_quiz_id',
                    'started_at',
                    'end_at',
                    'max_score',
                    'result_score',
                    'answers',
                ],
            ]);
    }

    public function testQuizAttemptReadAnswers(): void
    {
        $quiz = GiftQuiz::factory()->create();

        $question1 = GiftQuestion::factory()->state(['topic_gift_quiz_id' => $quiz->getKey()])->create();
        $question2 = GiftQuestion::factory()->state(['topic_gift_quiz_id' => $quiz->getKey()])->create();

        $attempt = QuizAttempt::factory()
            ->state(['user_id' => $this->student->getKey(), 'topic_gift_quiz_id' => $quiz->getKey()])
            ->create();

        $answer1 = AttemptAnswer::factory()
            ->state(['topic_gift_question_id' => $question1->getKey(), 'topic_gift_quiz_attempt_id' => $attempt->getKey()])
            ->create();

        $answer2 = AttemptAnswer::factory()
            ->state(['topic_gift_question_id' => $question2->getKey(), 'topic_gift_quiz_attempt_id' => $attempt->getKey()])
            ->create();

        $this->actingAs($this->student, 'api')
            ->getJson('api/quiz-attempts/' . $attempt->getKey())
            ->assertOk()
            ->assertJsonFragment([
                'max_score' => $question1->score + $question2->score,
                'result_score' => $answer1->score + $answer2->score,
            ])
            ->assertJsonCount(2, 'data.answers')
            ->assertJsonFragment([
                'topic_gift_question_id' => $answer1->topic_gift_question_id,
                'score' => $answer1->score,
                'answer' => $answer1->answer,
                'feedback' => $answer1->feedback,
            ])
            ->assertJsonFragment([
                'topic_gift_question_id' => $answer2->topic_gift_question_id,
                'score' => $answer2->score,
                'answer' => $answer2->answer,
                'feedback' => $answer2->feedback,
            ]);
    }
}
