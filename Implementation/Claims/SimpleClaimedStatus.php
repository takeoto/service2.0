<?php

namespace Implementation\Claims;

class SimpleClaimedStatus implements ClaimedStatusInterface
{
    private array $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }
    
    public function isCorrect(string $name = null): bool
    {
        return $name === null ? empty($this->errors) : !isset($this->errors[$name]);
    }

    public function whyItsNotCorrect(string $name = null): array
    {
        if ($name === null) {
            return $this->errors;
        }
        
        return $this->errors[$name] ?? [];
    }
}