<?php

namespace App\Tests\Unit\Infrastructure;

use App\Infrastructure\PuzzleJsonFormatter;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PuzzleJsonFormatterTest extends TestCase
{
    private PuzzleJsonFormatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new PuzzleJsonFormatter();
    }

    public function testShouldPopulatePuzzleWithSquare(): void
    {
        $json = [
            'squares' => [
                [
                    'x' => 1,
                    'y' => 2,
                    'value' => 3
                ]
            ]
        ];

        $puzzle = $this->formatter->format($json);

        $this->assertTrue(isset($puzzle[2][1]));
        $this->assertSame(3, $puzzle[2][1]);
    }

    public function testShouldFormatEmptyPuzzle(): void
    {
        $puzzle = $this->formatter->format(['squares' => []]);

        $this->assertCount(9, $puzzle);
        foreach ($puzzle as $row) {
            $this->assertCount(9, $row);
            foreach ($row as $value) {
                $this->assertNull($value);
            }
        }
    }

    /** @dataProvider invalidDataProvider */
    public function testShouldValidateInvalidData(array $puzzle): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->formatter->format($puzzle);
    }

    public function invalidDataProvider(): Generator
    {
        yield 'Missing squares' => [
            []
        ];
        yield 'Missing x' => [
            [
                'square' => [
                    'y' => 1,
                    'value' => 1
                ]
            ]
        ];
        yield 'Missing y' => [
            [
                'square' => [
                    'x' => 1,
                    'value' => 1
                ]
            ]
        ];
        yield 'Missing value' => [
            [
                'square' => [
                    'x' => 1,
                    'y' => 1,
                ]
            ]
        ];
        yield 'Invalid x' => [
            [
                'square' => [
                    'x' => 1,
                    'y' => 10,
                    'value' => 1,
                ]
            ]
        ];
        yield 'Invalid y' => [
            [
                'square' => [
                    'x' => 1,
                    'y' => 10,
                    'value' => 1,
                ]
            ]
        ];
        yield 'Invalid value' => [
            [
                'square' => [
                    'x' => 1,
                    'y' => 1,
                    'value' => 10,
                ]
            ]
        ];
    }
}
