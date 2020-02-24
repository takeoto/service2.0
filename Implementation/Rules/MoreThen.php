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
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        return $this->moreThen < $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return ["Value \"{$this->value}\" less then \"$this->moreThen\"!"];
    }
}
