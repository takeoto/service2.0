<?php

namespace Implementation\Services;

interface ValueControlInterface
{
    public function resolve(string $name, $value): StrictValueInterface;
}