<?php

namespace Implementation\Rules;

use Core\RuleInterface;

class ChainRule implements RuleInterface
{
    /**
     * @var RuleInterface
     */
    private $rules;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        $this->errors = [];
        $isPassed = true;

        /** @var RuleInterface $rule */
        foreach ($this->rules as $rule) {
            if ($isPassed &= $rule->isPassed($value)) {
                continue;
            }

            array_push($this->errors, ...$rule->getErrors());
            break;
        }

        return (bool)$isPassed;
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
