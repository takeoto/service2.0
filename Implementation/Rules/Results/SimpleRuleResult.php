<?php

namespace Implementation\Rules\Results;

class SimpleRuleResult implements RuleResultInterface
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var bool
     */
    private $isPassed;

    public function __construct(bool $passed, array $errors)
    {
        $this->isPassed = $passed;
        $this->errors = $errors;
    }
    
    /**
     * @inheritDoc
     */
    public function isPassed(): bool
    {
        return $this->isPassed;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
