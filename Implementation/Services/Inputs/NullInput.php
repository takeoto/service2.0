<?php

namespace Implementation\Services\Inputs;

use Implementation\Services\Claims\SimpleInputState;
use Implementation\Services\InputInterface;
use Implementation\Services\InputStateInterface;

class NullInput implements InputInterface
{
    private ?SimpleInputState $claimsState;

    public function __construct(InputStateInterface $state = null)
    {
        $this->claimsState = $state;
    }

    public function has(string $name): bool
    {
        return false;
    }

    public function get(string $name)
    {
        return null;
    }

    public function getState(): InputStateInterface
    {
        return $this->claimsState ?: $this->claimsState = new SimpleInputState();
    }
}