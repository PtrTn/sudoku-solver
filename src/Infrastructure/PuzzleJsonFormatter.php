<?php

declare(strict_types=1);

namespace App\Infrastructure;

use InvalidArgumentException;

final class PuzzleJsonFormatter
{
    private const PUZZLE_SIZE = 9;

    public function format(array $json): array
    {
        if (!isset($json['squares'])) {
            throw new InvalidArgumentException('Invalid data structure in puzzle');
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
            throw new InvalidArgumentException('Invalid square data in puzzle');
        }
        if ($square['x'] < 0 || $square['x'] >= self::PUZZLE_SIZE) {
            throw new InvalidArgumentException('Invalid x in puzzle');
        }
        if ($square['y'] < 0 || $square['x'] >= self::PUZZLE_SIZE) {
            throw new InvalidArgumentException('Invalid y in puzzle');
        }
        if ($square['value'] < 1 || $square['value'] > 9) {
            throw new InvalidArgumentException('Invalid value in puzzle');
        }
    }

    private function createEmptyPuzzle(): array
    {
        return array_fill(
            0,
            self::PUZZLE_SIZE,
            array_fill(
                0,
                self::PUZZLE_SIZE,
                null
            )
        );
    }
}
