<?php

use App\Domain\Services\CyclicDependency;

test('it detects cyclic dependencies', function () {

    $dependencyAggregator = $this->oneDependencyAggregator()
        ->addClassDependencies(
            $this->oneClassDependencies()->withFqcn('A')->withDependencies(['B'])->build()
        )
        ->addClassDependencies(
            $this->oneClassDependencies()->withFqcn('B')->withDependencies(['C'])->build()
        )
        ->addClassDependencies(
            $this->oneClassDependencies()->withFqcn('C')->withDependencies(['A'])->build()
        )
        ->build();

    $cycles = app(CyclicDependency::class)->detect($dependencyAggregator->classes());

    expect($cycles)->toBe([
        ['A', 'B', 'C'],
    ]);
});

test('it detects classes with multiple cycles', function () {

    $dependencyAggregator = $this->oneDependencyAggregator()
        ->addClassDependencies(
            $this->oneClassDependencies()->withFqcn('A')->withDependencies(['B', 'C'])->build()
        )
        ->addClassDependencies(
            $this->oneClassDependencies()->withFqcn('B')->withDependencies(['A'])->build()
        )
        ->addClassDependencies(
            $this->oneClassDependencies()->withFqcn('C')->withDependencies(['A'])->build()
        )
        ->build();

    $cycles = app(CyclicDependency::class)->detect($dependencyAggregator->classes());

    expect($cycles)->toBe([
        ['A', 'B'],
        ['A', 'C'],
    ]);
});