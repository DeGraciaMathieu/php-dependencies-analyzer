<?php

namespace Tests\Builders;

use App\Domain\ValueObjects\Fqcn;
use App\Domain\ValueObjects\IsAbstract;
use App\Domain\ValueObjects\IsInterface;
use App\Domain\ValueObjects\Dependencies;
use App\Domain\Entities\ClassDependencies;

class ClassDependenciesBuilder
{
    private string $fqcn = 'App\Domain\Entities\User';
    private array $dependencies = [];
    private bool $isInterface = false;
    private bool $isAbstract = false;

    public function withFqcn(string $fqcn): self
    {
        $this->fqcn = $fqcn;

        return $this;
    }

    public function withDependencies(array $dependencies): self
    {
        $this->dependencies = $dependencies;

        return $this;
    }

    public function isInterface(): self
    {
        $this->isInterface = true;

        return $this;
    }

    public function isAbstract(): self
    {
        $this->isAbstract = true;

        return $this;
    }

    public function build(): ClassDependencies
    {
        return new ClassDependencies(
            new Fqcn($this->fqcn),
            new Dependencies($this->dependencies),
            new IsInterface($this->isInterface),
            new IsAbstract($this->isAbstract),
        );
    }
}

