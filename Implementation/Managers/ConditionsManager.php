<?php

class ConditionsManager
{
    /**
     * @param ConditionInterface ...$conditions
     * @return ConditionsInterface
     */
    public static function makeList(ConditionInterface ...$conditions): ConditionsInterface
    {
        return new Conditions(...$conditions);
    }

    /**
     * @param string $name
     * @param $value
     * @param RuleInterface $rule
     * @return ConditionInterface
     */
    public static function makeOne(string $name, $value, RuleInterface $rule): ConditionInterface
    {
        return new SimpleCondition($name, $value, $rule);
    }

    /**
     * @param ConditionsInterface $conditions
     * @return bool
     */
    public static function isListCanBeUsed(ConditionsInterface $conditions): bool
    {
        $result = true;

        $conditions->each(function ($item) use (&$result) {
            /** @var ConditionInterface $item */
            $result &= ConditionsManager::isCanBeUsed($item);
        });

        return (bool)$result;
    }

    /**
     * @param ConditionInterface $condition
     * @return bool
     */
    public static function isCanBeUsed(ConditionInterface $condition): bool
    {
        return $condition->followRule()->isPassed();
    }

    /**
     * @param ConditionsInterface $conditions
     * @return array
     */
    public static function getListErrors(ConditionsInterface $conditions): array
    {
        $result = [];

        $conditions->each(function ($item) use (&$result) {
            /** @var ConditionInterface $item */
            $result[$item->getName()] = $item->followRule()->getErrors();
        });

        return $result;
    }
}
