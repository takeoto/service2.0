<?php

class BoolRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        $errors = [];

        !is_bool($value) && $errors[] = 'Value must be boolean!';

        return new SimpleRuleResult($errors);
    }
}
