<?php

declare(strict_types=1);

namespace App\Infrastructure;

use InvalidArgumentException;

final class PuzzleJsonFormatter
{
    public function format(array $json): array
    {
        if (!isset($json['squares'])) {
            throw new InvalidArgumentException('Invalid data structure in puzzle file');
        }

        $puzzle = $this->createEmptyPuzzle();
        foreach ($json['squares'] as $square) {
            $this->validateSquare($square);
            $x = $square['x'];
            $y = $square['y'];
            $value = $square['value'];

            $puzzle[$y][$x] = $value;
        }

        return $puzzle;
    }

    private function validateSquare(array $square)
    {
        if (!isset($square['x'], $square['y'], $square['value'])) {
            throw new InvalidArgumentException('Invalid square data in puzzle file');
        }
    }

    private function createEmptyPuzzle(): array
    {
        return array_fill(0, 9, array_fill(0, 9, null));
    }
}
