<?php

namespace App\Application\Weakness;

class WeaknessRequest
{
    public function __construct(
        public readonly string $path,
        public readonly array $filters,
    ) {}
}