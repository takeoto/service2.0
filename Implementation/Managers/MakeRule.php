<?php

namespace Implementation\Managers;

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
     * @param $entityManager
     * @param string $className
     * @return RuleInterface
     */
    public static function entityExists($entityManager, string $className): RuleInterface
    {
        return new EntityExistRule($entityManager, $className);
    }

    /**
     * @param array $values
     * @return RuleInterface
     */
    public static function oneOf(array $values): RuleInterface
    {
        return new OneOfRule($values);
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
