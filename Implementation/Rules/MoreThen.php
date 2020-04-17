<?php

namespace Implementation\Rules;

use Core\RuleInterface;

class MoreThen implements RuleInterface
{
    /**
     * @var float
     */
    private $moreThen;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(float $moreThen)
    {
        $this->moreThen = $moreThen;
    }

    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        $this->errors = [];

        if (!$isPassed = $this->moreThen < $value) {
            $this->errors[] = "Value \"{$value}\" less then \"$this->moreThen\"!";
        }

        return $isPassed;
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
