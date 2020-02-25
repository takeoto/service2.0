<?php

class IntRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        $errors = [];

        !is_int($value) && $errors[] = 'Value must be integer';

        return new SimpleRuleResult($errors);
    }
}
