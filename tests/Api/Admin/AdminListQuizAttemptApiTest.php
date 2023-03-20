<?php

namespace EscolaLms\TopicTypeGift\Tests\Api\Admin;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Sequence;

class AdminListQuizAttemptApiTest extends TestCase
{
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TopicTypeGiftPermissionSeeder::class);
    }

    public function testAdminQuizAttemptListUnauthorized(): void
    {
        $this->getJson('api/admin/quiz-attempts')
            ->assertUnauthorized();
    }

    public function testAdminQuizAttemptListFiltering(): void
    {
        $quiz = GiftQuiz::factory()->create();
        $quiz2 = GiftQuiz::factory()->create();

        $student = $this->makeStudent();
        $student2 = $this->makeStudent();

        QuizAttempt::factory()
            ->state(new Sequence(
                ['user_id' => $student->getKey(), 'topic_gift_quiz_id' => $quiz->getKey()],
                ['user_id' => $student->getKey(), 'topic_gift_quiz_id' => $quiz2->getKey()],
                ['user_id' => $student->getKey(), 'topic_gift_quiz_id' => $quiz2->getKey()],
                ['user_id' => $student2->getKey(), 'topic_gift_quiz_id' => $quiz2->getKey()],
            ))
            ->count(4)
            ->create();

        $this->actingAs($this->makeAdmin(), 'api')->getJson('api/admin/quiz-attempts?topic_gift_quiz_id=' . $quiz->getKey())
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->actingAs($this->makeAdmin(), 'api')->getJson('api/admin/quiz-attempts?user_id=' . $student->getKey())
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }
}
