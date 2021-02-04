<?php

namespace Implementation\Values;

interface ValueControlInterface
{
    public function resolve(string $name, $value): StrictValueInterface;
}