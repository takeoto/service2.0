<?php

namespace Implementation\Rules;

class BoolRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        return new TrueOrErrorRuleResult(
            is_bool($value),
            'Value must be boolean!'
        );
    }
}
