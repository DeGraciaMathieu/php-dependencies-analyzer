<?php

namespace App\Presenter\Commands\Weakness\Summary;

class SummaryViewModel
{
    public function __construct(
        public readonly array $metrics,
        public readonly int $totalClasses,
        public readonly float $delta,
    ) {
    }
}
