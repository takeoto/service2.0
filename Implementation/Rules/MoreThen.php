<?php


class MoreThen implements RuleInterface
{
    /**
     * @var float
     */
    private $moreThen;

    /**
     * @var mixed
     */
    private $value;

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
