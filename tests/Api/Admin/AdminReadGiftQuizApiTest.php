<?php

namespace EscolaLms\TopicTypeGift\Tests\Api\Admin;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Courses\Database\Seeders\CoursesPermissionSeeder;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Tests\TestCase;

class AdminReadGiftQuizApiTest extends TestCase
{
    use CreatesUsers;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CoursesPermissionSeeder::class);
        $this->seed(TopicTypeGiftPermissionSeeder::class);
        $this->admin = $this->makeAdmin();
    }

    public function testAdminReadGiftQuiz(): void
    {
        $quiz = GiftQuiz::factory()->create([
            'value' => 'test',
            'max_attempts' => 1,
            'max_execution_time' => 60,
        ]);

        $this->actingAs($this->admin, 'api')
            ->json('GET', 'api/admin/gift-quizes/' . $quiz->getKey())
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'value',
                    'max_attempts',
                    'max_execution_time',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $quiz->getKey(),
                    'value' => 'test',
                    'max_attempts' => 1,
                    'max_execution_time' => 60,
                ],
            ]);
    }
}
