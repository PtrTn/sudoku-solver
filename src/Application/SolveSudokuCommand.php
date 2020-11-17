<?php

declare(strict_types=1);

namespace App\Application;

final class SolveSudokuCommand
{
    private array $puzzle;

    public function __construct(array $puzzle)
    {
        $this->puzzle = $puzzle;
    }
}
