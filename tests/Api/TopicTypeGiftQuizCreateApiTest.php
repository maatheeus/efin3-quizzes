<?php

namespace EscolaLms\TopicTypeGift\Tests\Api;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Courses\Database\Seeders\CoursesPermissionSeeder;
use EscolaLms\Courses\Models\Course;
use EscolaLms\Courses\Models\Lesson;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Tests\TestCase;

class TopicTypeGiftQuizCreateApiTest extends TestCase
{
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CoursesPermissionSeeder::class);
    }

    public function testCreateGiftQuiz(): void
    {
        $lesson = Lesson::factory()
            ->for(Course::factory())
            ->create();

        $this->response = $this->actingAs($this->makeAdmin(), 'api')
            ->postJson('/api/admin/topics', [
                'title' => 'GiftQuiz',
                'lesson_id' => $lesson->getKey(),
                'topicable_type' => GiftQuiz::class,
                'max_attempts' => 2,
                'max_execution_time' => 10,
                'value' => 'lorem ipsum',
            ])
            ->assertCreated();

        $data = $this->response->getData()->data;
        $value = $data->topicable->value;

        $this->assertDatabaseHas('topic_gift_quizzes', [
            'value' => $value,
            'max_attempts' => 2,
            'max_execution_time' => 10,
        ]);
    }
}
