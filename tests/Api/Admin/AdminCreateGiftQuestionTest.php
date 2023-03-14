<?php

namespace EscolaLms\TopicTypeGift\Tests\Api\Admin;

class AdminCreateGiftQuestionTest extends GiftQuestionTestCase
{
    public function testAdminCreateGiftQuestionUnauthorized(): void
    {
        $this->postJson('api/admin/gift-questions')
            ->assertUnauthorized();
    }

    public function testAdminCreateGiftQuestion(): void
    {
        $value = 'Two plus two equals {=four =4}';

        $this->actingAs($this->admin, 'api')
            ->postJson('api/admin/gift-questions', [
                'topic_gift_quiz_id' => $this->quiz->getKey(),
                'value' => $value,
            ])
            ->assertCreated();

        $this->assertDatabaseHas('topic_gift_questions', [
            'value' => $value,
            'topic_gift_quiz_id' => $this->quiz->getKey(),
        ]);
    }
}
