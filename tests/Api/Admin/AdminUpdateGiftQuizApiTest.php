<?php

namespace EscolaLms\TopicTypeGift\Tests\Api\Admin;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
use EscolaLms\TopicTypeGift\Tests\TestCase;

class AdminUpdateGiftQuizApiTest extends TestCase
{
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(TopicTypeGiftPermissionSeeder::class);
    }

    public function testAdminUpdateGiftQuizUnauthorized(): void
    {
        $this
            ->putJson('api/admin/gift-quizes/123')
            ->assertUnauthorized();
    }

    public function testAdminUpdateGiftQuizForbidden(): void
    {
        $quiz = GiftQuiz::factory()->create();

        $this
            ->actingAs($this->makeStudent(), 'api')
            ->putJson('api/admin/gift-quizes/' . $quiz->getKey())
            ->assertForbidden();
    }

    public function testAdminUpdateGiftQuiz(): void
    {
        $quiz = GiftQuiz::factory()->create();
        $data = GiftQuiz::factory()->make()->toArray();

        $this
            ->actingAs($this->makeAdmin(), 'api')
            ->putJson('api/admin/gift-quizes/' . $quiz->getKey(), $data)
            ->assertOk()
            ->assertJsonFragment([
                'id' => $quiz->getKey(),
                'questions' => [],
            ] + $data);
    }
}
