<?php

declare(strict_types=1);

namespace App\Infrastructure;

use InvalidArgumentException;
use RuntimeException;

final class FileSystemSudokuRepository
{
    public function getContentsForFilePath(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException('Sudoku file does not exist');
        }

        $contents = file_get_contents($filePath);
        if ($contents === false) {
            throw new RuntimeException('Unable to load sudoku file from disk');
        }

        return $contents;
    }
}
