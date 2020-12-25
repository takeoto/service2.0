<?php

namespace Implementation\Services;

interface InputStateInterface
{
    public function isCanBeUsed(string $name = null): bool;
    public function whyItsCantBeUsed(string $name = null): array;
}