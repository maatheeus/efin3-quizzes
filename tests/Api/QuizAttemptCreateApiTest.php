<?php

namespace EscolaLms\TopicTypeGift\Tests\Api;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;

class QuizAttemptCreateApiTest extends GiftQuestionTestCase
{
    use CreatesUsers;

    public function testCreateQuizAttemptUnauthorized(): void
    {
        $this->postJson('api/quiz-attempts', [
            'topic_gift_quiz_id' => $this->quiz->getKey(),
        ])
            ->assertUnauthorized();
    }

    public function testCreateQuizAttemptForbidden(): void
    {
        $this->actingAs($this->makeStudent(), 'api')
            ->postJson('api/quiz-attempts', [
                'topic_gift_quiz_id' => $this->quiz->getKey(),
            ])
            ->assertForbidden();
    }

    public function testCreateQuizAttempt(): void
    {
        $student = $this->makeStudent();
        $this->topic->course->users()->sync($student);

        $this->actingAs($student, 'api')
            ->postJson('api/quiz-attempts', [
                'topic_gift_quiz_id' => $this->quiz->getKey(),
            ])
            ->assertCreated();

        $this->assertDatabaseHas('topic_gift_quiz_attempts', [
            'user_id' => $student->getKey(),
            'topic_gift_quiz_id' => $this->quiz->getKey(),
        ]);
    }

    public function testShouldNotCreateQuizAttemptWhenMaxNumberIsExceeded(): void
    {
        $this->quiz = GiftQuiz::factory()
            ->state(['max_attempts' => 0])
            ->create();
        $this->topic->topicable()->associate($this->quiz)->save();

        $student = $this->makeStudent();
        $this->topic->course->users()->sync($student);

        $this->actingAs($student, 'api')
            ->postJson('api/quiz-attempts', [
                'topic_gift_quiz_id' => $this->quiz->getKey(),
            ])
            ->assertStatus(400);

        $this->assertDatabaseMissing('topic_gift_quiz_attempts', [
            'user_id' => $student->getKey(),
            'topic_gift_quiz_id' => $this->quiz->getKey(),
        ]);
    }
}
