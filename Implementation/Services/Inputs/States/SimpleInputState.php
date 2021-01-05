<?php

namespace Implementation\Services\Inputs\States;

class SimpleInputState implements InputStateInterface
{
    private array $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }

    public function isCanBeUsed(string $name = null): bool
    {
        return $name === null
            ? empty($this->errors)
            : !isset($this->errors[$name]);
    }

    public function whyItsCantBeUsed(string $name = null): array
    {
        if ($name === null) {
            return $this->errors;
        }
        
        return $this->errors[$name] ?? [];
    }
}