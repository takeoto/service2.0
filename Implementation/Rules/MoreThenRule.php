<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleResultInterface;
use Implementation\Rules\Results\TrueOrErrorRuleResult;

class MoreThenRule implements RuleInterface
{
    /**
     * @var float
     */
    private $moreThen;


    public function __construct(float $moreThen)
    {
        $this->moreThen = $moreThen;
    }

    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        return new TrueOrErrorRuleResult(
            $this->moreThen < $value,
            "Value \"$value\" must be more then \"$this->moreThen\"!"
        );
    }
}
