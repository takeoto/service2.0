<?php declare(strict_types=1);

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleStateInterface;
use Implementation\Rules\Results\TrueOrErrorRuleState;

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
    public function pass($value): RuleStateInterface
    {
        return new TrueOrErrorRuleState(
            $this->moreThen < $value,
            "Value \"$value\" must be more then \"$this->moreThen\"!"
        );
    }
}
