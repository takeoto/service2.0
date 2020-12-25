<?php

namespace Implementation\Services\Inputs;

use Implementation\Services\Claims\SimpleInputState;
use Implementation\Services\InputInterface;
use Implementation\Services\InputStateInterface;
use Implementation\Services\StrictValue;
use Implementation\Services\StrictValueInterface;

class NullInput implements InputInterface
{
    private ?SimpleInputState $claimsState = null;

    public function has(string $name): bool
    {
        return true;
    }

    public function get(string $name): StrictValueInterface
    {
        return new StrictValue(null);
    }

    public function state(): InputStateInterface
    {
        return $this->claimsState ?: $this->claimsState = new SimpleInputState();
    }
}