<?php declare(strict_types=1);

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleStateInterface;
use Implementation\Rules\Results\TrueOrErrorRuleState;

class IntRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function pass($value): RuleStateInterface
    {
        return new TrueOrErrorRuleState(
            is_int($value),
            'Value must be integer!'
        );
    }
}
