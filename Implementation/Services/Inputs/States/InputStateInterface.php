<?php

namespace Implementation\Services\Inputs\States;

interface InputStateInterface
{
    public function isCanBeUsed(string $name = null): bool;
    public function whyItsCantBeUsed(string $name = null): array;
}