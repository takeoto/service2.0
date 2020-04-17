<?php

namespace Implementation\Rules;

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
