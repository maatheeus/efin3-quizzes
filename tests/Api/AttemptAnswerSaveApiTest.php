<?php

namespace EscolaLms\TopicTypeGift\Tests\Api;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Database\Seeders\TopicTypeGiftPermissionSeeder;
use EscolaLms\TopicTypeGift\Enum\AnswerKeyEnum;
use EscolaLms\TopicTypeGift\Enum\QuestionTypeEnum;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Tests\TestCase;

class AttemptAnswerSaveApiTest extends TestCase
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

    public function testSaveAttemptAnswerUnauthorized(): void
    {
        $this->postJson('api/quiz-answers')
            ->assertUnauthorized();
    }

    public function testSaveAttemptAnswerForbidden(): void
    {
        $question = GiftQuestion::factory()->create();

        $this->actingAs($this->makeStudent(), 'api')
            ->postJson('api/quiz-answers', [
                'topic_gift_quiz_attempt_id' => $this->attempt->getKey(),
                'topic_gift_question_id' => $question->getKey(),
            ])
            ->assertForbidden();
    }

    /**
     * @dataProvider questionDataProvider
     */
    public function testSaveAttemptAnswer(string $question, string $type, array $answer, float $score = 1, float $resultScore = 1, string $feedback = ''): void
    {
        $question = GiftQuestion::factory()
            ->state([
                'value' => $question,
                'type' => $type,
                'score' => $score,
            ])->create();

        $this->actingAs($this->student, 'api')->postJson('api/quiz-answers', [
                'topic_gift_quiz_attempt_id' => $this->attempt->getKey(),
                'topic_gift_question_id' => $question->getKey(),
                'answer' => $answer,
            ])->assertOk();

        $this->assertDatabaseHas('topic_gift_attempt_answers', [
            'topic_gift_question_id' => $question->getKey(),
            'feedback' => $feedback,
            'score' => $resultScore,
        ]);
    }

    public function questionDataProvider(): array
    {
        return [
            [
                'question' => 'Who\'s buried in Grant\'s tomb?{~no one ~Napoleon =Grant ~Churchill ~Mother Teresa }',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE,
                'answer' => [AnswerKeyEnum::TEXT => 'Grant'],
            ],
            [
                'question' => 'Who\'s buried in Grant\'s tomb?{=Grant #Great! ~no one ~Napoleon ~Churchill ~Mother Teresa }',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE,
                'answer' => [AnswerKeyEnum::TEXT => 'no one'],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => '::Grants tomb::Who is buried in Grant\'s tomb in New York City? { =Grant ~No one #Was true for 12 years, but Grant\'s remains were buried in the tomb in 1897 ~Napoleon #He was buried in France ~Churchill #He was buried in England ~Mother Teresa #She was buried in India }',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE,
                'answer' => [AnswerKeyEnum::TEXT => 'No one'],
                'score' => 1,
                'resultScore' => 0,
                'feedback' => 'Was true for 12 years, but Grant\'s remains were buried in the tomb in 1897',
            ],
            [
                'question' => 'What two people are entombed in Grant\'s tomb? { ~%-100%No one ~%50%Grant ~%50%Grant\'s wife ~%-100%Grant\'s father }',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE_WITH_MULTIPLE_RIGHT_ANSWERS,
                'answer' => [AnswerKeyEnum::MULTIPLE => ['Grant']],
                'score' => 1,
                'resultScore' => 0.5,
            ],
            [
                'question' => 'What two people are entombed in Grant\'s tomb? { ~%-100%No one ~%50%Grant ~%50%Grant\'s wife ~%-100%Grant\'s father }',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE_WITH_MULTIPLE_RIGHT_ANSWERS,
                'answer' => [AnswerKeyEnum::MULTIPLE => ['Grant', 'Grant\'s wife']],
            ],
            [
                'question' => '::TrueStatement about Grant::Grant was buried in a tomb in New York City.{T}',
                'type' => QuestionTypeEnum::TRUE_FALSE,
                'answer' => [AnswerKeyEnum::BOOL => true],
            ],
            [
                'question' => '// question: 0 name: FalseStatement using {FALSE} style
                               ::FalseStatement about sun::The sun rises in the West.{FALSE}',
                'type' => QuestionTypeEnum::TRUE_FALSE,
                'answer' => [AnswerKeyEnum::BOOL => true],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'Who\'s buried in Grant\'s tomb?{=Grant =Ulysses S. Grant =Ulysses Grant}',
                'type' => QuestionTypeEnum::SHORT_ANSWERS,
                'answer' => [AnswerKeyEnum::TEXT => 'Ulysses S. Grant'],
            ],
            [
                'question' => 'Who\'s buried in Grant\'s tomb?{=Grant =Ulysses S. Grant =Ulysses Grant}',
                'type' => QuestionTypeEnum::SHORT_ANSWERS,
                'answer' => [AnswerKeyEnum::TEXT => 'wrong'],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'Two plus two equals {=four =4}',
                'type' => QuestionTypeEnum::SHORT_ANSWERS,
                'answer' => [AnswerKeyEnum::TEXT => 'four'],
            ],
            [
                'question' => 'Match the following countries with their corresponding capitals. {
                               =Canada -> Ottawa
                               =Italy  -> Rome
                               =Japan  -> Tokyo
                               =India  -> New Delhi
                               }',
                'type' => QuestionTypeEnum::MATCHING,
                'answer' => [AnswerKeyEnum::MATCHING => [
                    'Canada' => 'Ottawa',
                    'Italy' => 'Rome',
                    'Japan' => 'Tokyo',
                    'India' => 'New Delhi',
                ]],
            ],
            [
                'question' => 'Match the following countries with their corresponding capitals. {
                               =Canada -> Ottawa
                               =Italy  -> Rome
                               =Japan  -> Tokyo
                               =India  -> New Delhi
                               }',
                'type' => QuestionTypeEnum::MATCHING,
                'answer' => [AnswerKeyEnum::MATCHING => [
                    'Canada' => 'Rome',
                    'Italy' => 'Ottawa',
                    'Japan' => 'Tokyo',
                    'India' => 'New Delhi',
                ]],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'Moodle costs {~lots of money =nothing ~a small amount} to download from moodle.org.',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE,
                'answer' => [AnswerKeyEnum::TEXT => 'nothing'],
            ],
            [
                'question' => 'When was Ulysses S. Grant born?{#1822:5}',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 1822],
            ],
            [
                'question' => 'When was Ulysses S. Grant born?{#1822:5}',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 1827],
            ],
            [
                'question' => 'When was Ulysses S. Grant born?{#1822:5}',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 1816],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'What is the value of pi (to 3 decimal places)? {#3.14159:0.0005}.',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 3.14159],
            ],
            [
                'question' => 'What is the value of pi (to 3 decimal places)? {#3.141..3.142}.',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 3.141],
            ],
            [
                'question' => 'What is the value of pi (to 3 decimal places)? {#3.141..3.142}.',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 3.142],
            ],
            [
                'question' => 'What is the value of pi (to 3 decimal places)? {#3.141..3.142}.',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 3.140],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'What is the value of pi (to 3 decimal places)? {#3.141..3.142}.',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 3.143],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'When was Ulysses S. Grant born?{#1822}',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 1822],
            ],
            [
                'question' => 'When was Ulysses S. Grant born?{#1822}',
                'type' => QuestionTypeEnum::NUMERICAL_QUESTION,
                'answer' => [AnswerKeyEnum::NUMERIC => 1820],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'Write a short biography of Dag Hammarskjöld. {}',
                'type' => QuestionTypeEnum::ESSAY,
                'answer' => [AnswerKeyEnum::TEXT => 'essay'],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => 'You can use your pencil and paper for these next math questions.',
                'type' => QuestionTypeEnum::DESCRIPTION,
                'answer' => [],
                'score' => 1,
                'resultScore' => 0,
            ],
            [
                'question' => '::Jesus hometown::Jesus Christ was from {
                              ~Jerusalem#This was an important city, but the wrong answer.
                              ~%25%Bethlehem#He was born here, but not raised here.
                              ~%50%Galilee#You need to be more specific.
                              =Nazareth#Yes! That\'s right!
                              }.',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE_WITH_MULTIPLE_RIGHT_ANSWERS,
                'answer' => [AnswerKeyEnum::MULTIPLE => ['Nazareth']],
            ],
            [
                'question' => '::Jesus hometown::Jesus Christ was from {
                              ~Jerusalem#This was an important city, but the wrong answer.
                              ~%25%Bethlehem#He was born here, but not raised here.
                              ~%50%Galilee#You need to be more specific.
                              =Nazareth#Yes! That\'s right!
                              }.',
                'type' => QuestionTypeEnum::MULTIPLE_CHOICE_WITH_MULTIPLE_RIGHT_ANSWERS,
                'answer' => [AnswerKeyEnum::MULTIPLE => ['Bethlehem', 'Galilee']],
                'score' => 1,
                'resultScore' => 0.75,
            ],
        ];
    }
}
