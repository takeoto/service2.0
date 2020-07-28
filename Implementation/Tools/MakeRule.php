<?php

namespace Implementation\Tools;

use Core\RuleInterface;
use Implementation\Rules\BoolRule;
use Implementation\Rules\ChainRule;
use Implementation\Rules\IntRule;
use Implementation\Rules\MoreThenRule;
use Implementation\Rules\OneOfRule;

class MakeRule
{
    /**
     * @return RuleInterface
     */
    public static function int(): RuleInterface
    {
        return new IntRule();
    }

    /**
     * @return RuleInterface
     */
    public static function bool(): RuleInterface
    {
        return new BoolRule();
    }

    /**
     * @param array $values
     * @param bool $strict
     * @return RuleInterface
     */
    public static function oneOf(array $values, bool $strict = false): RuleInterface
    {
        return new OneOfRule($values, $strict);
    }

    /**
     * @param RuleInterface ...$rules
     * @return RuleInterface
     */
    public static function chain(RuleInterface ...$rules): RuleInterface
    {
        return new ChainRule(...$rules);
    }

    /**
     * @param float $value
     * @return RuleInterface
     */
    public static function moreThen(float $value): RuleInterface
    {
        return new MoreThenRule($value);
    }
}
