<?php

namespace Implementation\Rules;

use Core\RuleInterface;

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
