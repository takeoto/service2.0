<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleStateInterface;
use Implementation\Rules\Results\TrueOrErrorRuleState;

class BoolRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function pass($value): RuleStateInterface
    {
        return new TrueOrErrorRuleState(
            is_bool($value),
            'Value must be boolean!'
        );
    }
}
