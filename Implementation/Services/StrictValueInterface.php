<?php

namespace Implementation\Services;

interface StrictValueInterface
{
    public function asInt(): int;

    public function asBool(): bool;

    public function asString(): string;

    public function asArray(): array;

    public function original();

    public function asInstanceOf(string $class);
}