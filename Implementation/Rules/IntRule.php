<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleResultInterface;
use Implementation\Rules\Results\TrueOrErrorRuleResult;

class IntRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        return new TrueOrErrorRuleResult(
            is_int($value),
            'Value must be integer!'
        );
    }
}
