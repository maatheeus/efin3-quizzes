<?php

namespace EscolaLms\TopicTypeGift\Tests\Api\Admin;

use EscolaLms\TopicTypeGift\Models\GiftQuestion;

class AdminUpdateGiftQuestionTest extends GiftQuestionTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->question = GiftQuestion::factory()
            ->state(['topic_gift_quiz_id' => $this->quiz->getKey()])
            ->create();
    }

    public function testAdminUpdateGiftQuestionUnauthorized(): void
    {
        $this->putJson('api/admin/gift-questions/' . $this->question->getKey(), [
            'topic_gift_quiz_id' => $this->quiz->getKey(),
            'value' => 'new question',
        ])
            ->assertUnauthorized();
    }

    public function testAdminUpdateGiftQuestion(): void
    {
        $question = GiftQuestion::factory()->make();

        $this->actingAs($this->admin, 'api')
            ->putJson('api/admin/gift-questions/' . $this->question->getKey(), [
                'topic_gift_quiz_id' => $this->quiz->getKey(),
                'value' => $question->value,
                'score' => $question->score,
            ])
            ->assertOk();

        $this->assertDatabaseHas('topic_gift_questions', [
            'id' => $this->question->getKey(),
            'topic_gift_quiz_id' => $this->quiz->getKey(),
            'value' => $question->value,
            'score' => $question->score,
        ]);
    }
}
