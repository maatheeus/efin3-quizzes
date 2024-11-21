<?php

namespace Efin3\Quizzes\Http\Resources\TopicType\Client;

use EscolaLms\Courses\Http\Resources\TopicType\Contracts\TopicTypeResourceContract;
use Efin3\Quizzes\Models\TopicQuiz;
use Illuminate\Support\Facades\Storage;
use Efin3\Quizzes\Models\Game;
use Efin3\Quizzes\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TopicQuiz
 */
class GameResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request): array
    {
        $game = Game::find($this->game_id);
        $game->file = Storage::url($game->file);
        $game->preview = Storage::url('games/' . $game->id . "/" . "index.html");
    

        return [
            'id' => $this->id,
            'game_id' => $this->game_id,
            'url' => $game->file,
            'preview' => $game->preview
        ];
    }
}
