<?php

class SimpleRuleResult implements RuleResultInterface
{
    /**
     * @var array
     */
    private $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }
    
    /**
     * @inheritDoc
     */
    public function isPassed(): bool
    {
        return (bool)$this->errors;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
