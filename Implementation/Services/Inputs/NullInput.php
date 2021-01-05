<?php

namespace Implementation\Services\Inputs;

use Implementation\Services\Inputs\States\InputStateInterface;
use Implementation\Services\Inputs\States\SimpleInputState;
use Implementation\Services\StrictValue;
use Implementation\Services\StrictValueInterface;

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

    public function get(string $name): StrictValueInterface
    {
        return new StrictValue(null);
    }

    public function getState(): InputStateInterface
    {
        return $this->claimsState ?: $this->claimsState = new SimpleInputState();
    }
}