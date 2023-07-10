<?php

namespace EscolaLms\TopicTypeGift\Dtos;

use EscolaLms\Core\Dtos\Contracts\DtoContract;
use EscolaLms\Core\Dtos\Contracts\InstantiateFromRequest;
use Illuminate\Http\Request;

class QuizDto implements DtoContract, InstantiateFromRequest
{

    private string $value;
    private ?int $maxAttempts;
    private ?int $maxExecutionTime;
    private ?float $minPassScore;

    public function __construct(string $value, ?int $maxAttempts, ?int $maxExecutionTime, ?float $minPassScore)
    {
        $this->value = $value;
        $this->maxAttempts = $maxAttempts;
        $this->maxExecutionTime = $maxExecutionTime;
        $this->minPassScore = $minPassScore;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'max_attempts' => $this->maxAttempts,
            'max_execution_time' => $this->maxExecutionTime,
            'min_pass_score' => $this->minPassScore,
        ];
    }

    public static function instantiateFromRequest(Request $request): QuizDto
    {
        return new self(
            $request->input('value'),
            $request->input('max_attempts'),
            $request->input('max_execution_time'),
            $request->input('min_pass_score')
        );
    }
}
