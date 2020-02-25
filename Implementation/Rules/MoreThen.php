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
        $errors = [];

        $this->moreThen >= $value && $errors[] = "Value \"$value\" less then \"$this->moreThen\"!";

        return new SimpleRuleResult($errors);
    }
}
