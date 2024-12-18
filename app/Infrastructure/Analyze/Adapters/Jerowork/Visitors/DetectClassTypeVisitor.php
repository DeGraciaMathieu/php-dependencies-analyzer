<?php

namespace App\Infrastructure\Analyze\Adapters\Jerowork\Visitors;

use PhpParser\Node;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use App\Infrastructure\Analyze\Adapters\Jerowork\Collectors\ClassTypeCollector;

class DetectClassTypeVisitor extends NodeVisitorAbstract
{
    public ?string $namespace = null;
    public ?string $className = null;
    public ?bool $isAbstract = false;
    public ?bool $isInterface = false;

    public function __construct(
        private ClassTypeCollector $collector,
    ) {}

    public function beforeTraverse(array $nodes): void
    {
        //
    }

    public function enterNode(Node $node): void
    {
        if ($node instanceof Namespace_) {
            $this->collector->namespace = (string) $node->name;
        }

        if ($this->nodeAreClassOrEquivalent($node)) {

            $this->collector->className = (string) $node->name;

            if ($node instanceof Class_) {
                $this->collector->isAbstract = $node->isAbstract();
            }

            $this->collector->isInterface = $node instanceof Interface_;
        }
    }

    public function leaveNode(Node $node): void
    {
        //
    }

    private function nodeAreClassOrEquivalent(Node $node): bool
    {
        $parts = [Class_::class, Trait_::class, Interface_::class, Enum_::class];

        return in_array(get_class($node), $parts, true);
    }
}
