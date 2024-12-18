<?php

namespace App\Commands\Analyze\Class;

use LaravelZero\Framework\Commands\Command;
use App\Presenter\Analyze\Shared\Filters\Contracts\Transformer;
use App\Presenter\Analyze\Shared\Filters\Transformers\NullTransformer;
use App\Presenter\Analyze\Shared\Filters\Transformers\TargetTransformer;

class TransformerFactory
{
    public static function make(Command $command): Transformer
    {
        return match ($command->option('target')) {
            default => self::makeTargetTransformer($command),
            null => self::makeNullTransformer(),
        };
    }

    private static function makeTargetTransformer(Command $command): Transformer
    {
        return app(TargetTransformer::class, [
            'target' => $command->option('target'),
            'depthLimit' => $command->option('depth-limit'),
        ]);
    }

    private static function makeNullTransformer(): Transformer
    {
        return app(NullTransformer::class);
    }
}
