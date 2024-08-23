<?php

namespace Efin3\Quizzes\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Efin3\Quizzes\Models\TopicQuiz;
use Efin3\Quizzes\Models\Question;
use Efin3\Quizzes\Models\Answer;
use Efin3\Quizzes\Models\Alternative;

class GiftQuestionApiAdminController
{
    /**
     * Store a new quiz, question, and alternatives.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validar dados recebidos
        $validated = $request->validate([
            'type' => 'required|string|in:multiple_choice',
            'quiz' => 'required|array',
            'quiz.value' => 'required|string',
            'quiz.topic_quiz_id' => 'required|integer|exists:topic_quizzes,id',
            'question' => 'required|array',
            'question.text' => 'required|string',
            'question.resolution' => 'required|string',
            'alternatives' => 'required|array',
            'alternatives.*.text' => 'required|string',
            'alternatives.*.resolution' => 'required|string',
            'alternatives.*.is_correct' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $topicQuiz = TopicQuiz::findOrFail($validated['quiz']['topic_quiz_id']);


            $question = Question::create([
                'topic_quiz_id' => $topicQuiz->id,
                'question_text' => $validated['question']['text'],
                'resolution' => $validated['question']['resolution'],
            ]);


            $alternatives = array_map(function ($alternative) use ($question) {
                return [
                    'question_id' => $question->id,
                    'alternative_text' => $alternative['text'],
                    'resolution' => $alternative['resolution'],
                    'is_correct' => $alternative['is_correct'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $validated['alternatives']);

            Alternative::insert($alternatives);

            DB::commit();

            return response()->json([
                'message' => 'Quiz, question, and alternatives created successfully',
                'data' => [
                    'topic_quiz' => $topicQuiz,
                    'question' => $question,
                    'alternatives' => $alternatives,
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create quiz, question, or alternatives',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function saveAnswer(Request $request): JsonResponse
    {
        $user_id = auth()->id();

        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer',
            'answers.*.alternative_id' => 'required|integer',
        ]);

        $responses = [];

        try {
            foreach ($request->input('answers') as $answerData) {
                $question_id = $answerData['question_id'];
                $alternative_id = $answerData['alternative_id'];

                $checkalternative = Alternative::where('id', $alternative_id)->where('question_id', $question_id)->first();
                $checkquestion = Question::find($question_id)
                    ->alternatives()
                    ->where('is_correct', true)
                    ->first();

            
                $answer = Answer::create([
                    'question_id' => $question_id,
                    'alternative_id' => $alternative_id,
                    'user_id' => $user_id,
                ]);

                $responses[] = [
                    'question_id' => $question_id,
                    'is_correct_marked' => $checkalternative->is_correct,
                    'alternative_correct' => $checkquestion,
                ];
            }

            return response()->json([
                'message' => 'Answers created successfully',
                'data' => $responses,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create answers',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function get(Request $request, $id): JsonResponse
    {
        try {
            $topicQuiz = TopicQuiz::with(['questions.alternatives'])->findOrFail($id);
            $topicQuiz->questions->each(function ($question) {
                $question->alternatives->makeHidden('is_correct');
                $question->alternatives->makeHidden('resolution');
                $question->makeHidden('resolution');
            });

            return response()->json([
                'message' => 'Quiz retrieved successfully',
                'data' => $topicQuiz,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve quiz',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
