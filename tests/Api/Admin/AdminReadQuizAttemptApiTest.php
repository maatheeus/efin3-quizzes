<?php

namespace EscolaLms\TopicTypeGift\Tests\Api\Admin;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Tests\TestCase;

class AdminReadQuizAttemptApiTest extends TestCase
{
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TopicTypeGiftPermissionSeeder::class);
        $this->attempt = QuizAttempt::factory()->create();
    }

    public function testAdminQuizAttemptReadUnauthorized(): void
    {
        $this->getJson('api/admin/quiz-attempts/' . $this->attempt->getKey())
            ->assertUnauthorized();
    }

    public function testAdminQuizAttemptReadForbidden(): void
    {
        $this->actingAs($this->makeStudent(), 'api')
            ->getJson('api/admin/quiz-attempts/' . $this->attempt->getKey())
            ->assertForbidden();
    }

    public function testAdminQuizAttemptRead(): void
    {
        $this->actingAs($this->makeAdmin(), 'api')
            ->getJson('api/admin/quiz-attempts/' . $this->attempt->getKey())
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'topic_gift_quiz_id',
                    'started_at',
                    'end_at',
                    'max_score',
                    'min_pass_score',
                    'result_score',
                    'answers',
                ],
            ]);
    }
}
