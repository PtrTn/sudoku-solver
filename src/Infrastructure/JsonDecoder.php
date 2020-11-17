<?php

declare(strict_types=1);

namespace App\Infrastructure;

use RuntimeException;

final class JsonDecoder
{
    public function decode(string $json): array
    {
        $decoded = json_decode($json, true);

        if ($decoded === null) {
            throw new RuntimeException('Invalid json found in puzzle file');
        }

        return $decoded;
    }
}
