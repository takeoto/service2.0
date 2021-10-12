<?php declare(strict_types=1);

namespace Implementation\Providers;


interface ProviderInterface
{
    public function make(string $name, ...$params);

    public function has(string $name): bool;

    public function getNames(): array;
}