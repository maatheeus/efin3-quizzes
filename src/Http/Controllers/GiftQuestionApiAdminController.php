<?php

namespace Efin3\Quizzes\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Efin3\Quizzes\Models\TopicQuiz;
use Efin3\Quizzes\Models\Question;
use Efin3\Quizzes\Models\Answer;
use Efin3\Quizzes\Models\Game;
use Efin3\Quizzes\Models\Alternative;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

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

    public function update(Request $request, $id): JsonResponse
    {
        // Validar dados recebidos
        $validated = $request->validate([
            'type' => 'required|string|in:multiple_choice',
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
            // Encontrar a questão a ser atualizada pelo ID da questão
            $question = Question::where('id', $id)->firstOrFail();

            // Atualizar a questão com os novos dados
            $question->update([
                'question_text' => $validated['question']['text'],
                'resolution' => $validated['question']['resolution'],
            ]);

            // Apagar alternativas antigas associadas à questão
            Alternative::where('question_id', $question->id)->delete();

            // Inserir novas alternativas
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
                'message' => 'Quiz, question, and alternatives updated successfully',
                'data' => [
                    'question' => $question,
                    'alternatives' => $alternatives,
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update quiz, question, or alternatives',
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
                $question = Question::find($question_id);
                $checkquestion = $question
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
                    'resolution' => $question->resolution,
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

    public function destroy($id): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Encontrar a questão a ser removida pelo ID
            $question = Question::findOrFail($id);

            // Remover alternativas associadas à questão
            Alternative::where('question_id', $question->id)->delete();

            // Remover a questão
            $question->delete();

            DB::commit();

            return response()->json([
                'message' => 'Question and its alternatives removed successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to remove question and alternatives',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeGame(Request $request)
    {
        // Validação do nome e do arquivo
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:zip' // Garantir que o arquivo é um ZIP
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $name = $request->input('name');
        $file = $request->file('file');
    
        // Armazenar o arquivo ZIP temporariamente
        $zipPath = $file->storeAs('games', $file->getClientOriginalName());
    
        // Caminho completo do arquivo ZIP
        $fullPath = Storage::path($zipPath);
    
        // Criar uma instância de ZipArchive
        $zip = new ZipArchive;
    
        if ($zip->open($fullPath) === TRUE) {
            $indexFound = false;
            $allInRoot = true;
    
            // Iterar pelos arquivos no ZIP
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                $fileinfo = pathinfo($filename);
    
                // Verificar se existe um arquivo "index.html" na raiz
                if ($filename === 'index.html') {
                    $indexFound = true;
                }
    
                // Verificar se o arquivo está na raiz (sem subpastas)
                if (isset($fileinfo['dirname']) && $fileinfo['dirname'] !== '.') {
                    $allInRoot = false;
                }
            }
    
            // Fechar o ZIP após a validação
            $zip->close();
    
            // Validações
            if (!$indexFound) {
                return response()->json(['error' => 'O pacote não contém o arquivo index.html na raiz.'], 422);
            }
        
        } else {
            return response()->json(['error' => 'Falha ao abrir o arquivo ZIP.'], 500);
        }

        
        $game = Game::create([
            'name' => $name,
            'file' => $zipPath,
        ]);
        
        
        $extractToPath = Storage::path('games/' . $game->id);
    

        if (!Storage::exists('games/' . $game->id)) {
            Storage::makeDirectory('games/' . $game->id);
        }
    

        $zip->open($fullPath);
        $zip->extractTo($extractToPath);
        $zip->close();
    

        #Storage::delete($zipPath);
    
        return response()->json([
            'message' => 'Game uploaded and extracted successfully!',
            'name' => $name,
            'file' => Storage::url($zipPath),
            'preview' => Storage::url('games/' . $game->id . "/" . "index.html")
        ], 201);
    }

    public function getGame(Request $request)
    {
        $games = Game::paginate(20);


        foreach($games as $game)
        {
            $game->file = Storage::url($game->file);
            $game->preview = Storage::url('games/' . $game->id . "/" . "index.html");
        }

        return response()->json([
            'success' => true,
            'message' => 'Game list fetched successfully',
            'data' => [
                'current_page' => $games->currentPage(),
                'data' => $games->items(),
                'first_page_url' => $games->url(1),
                'from' => $games->firstItem(),
                'last_page' => $games->lastPage(),
                'last_page_url' => $games->url($games->lastPage()),
                'links' => $games->linkCollection(),
                'next_page_url' => $games->nextPageUrl(),
                'path' => $games->path(),
                'per_page' => $games->perPage(),
                'prev_page_url' => $games->previousPageUrl(),
                'to' => $games->lastItem(),
                'total' => $games->total(),
            ]
        ], 200);
    }

    public function getGameById(Request $request, $id)
    {
        $game = Game::find($id);
        $game->file = Storage::url($game->file);
        $game->preview = Storage::url('games/' . $game->id . "/" . "index.html");
    
        return [
            'data' => $game
        ];
    }

    public function updateGame(Request $request, $id)
    {
        // Validação dos campos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:zip,html'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buscar o jogo pelo ID
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        // Atualizar nome, se presente
        $game->name = $request->input('name');

        // Se um novo arquivo for enviado, substituí-lo
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('games', $file->getClientOriginalName());
            $game->file = $path;
        }

        // Salvar as mudanças no banco de dados
        $game->save();

        // Retornar a resposta de sucesso
        return response()->json([
            'message' => 'Game updated successfully!',
            'name' => $game->name,
            'file' => $game->file
        ], 200);
    }


    public function destroyGame($id)
    {
        // Buscar o jogo pelo ID
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        // Excluir o jogo
        $game->delete();

        // Retornar a resposta de sucesso
        return response()->json([
            'message' => 'Game deleted successfully!'
        ], 200);
    }

}
