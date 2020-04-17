<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleResultInterface;
use Implementation\Rules\Results\TrueOrErrorRuleResult;

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
