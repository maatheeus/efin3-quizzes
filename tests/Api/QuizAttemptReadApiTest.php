<?php

namespace EscolaLms\TopicTypeGift\Tests\Api;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
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
                ],
            ]);
    }
}
