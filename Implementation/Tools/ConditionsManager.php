<?php declare(strict_types=1);

namespace Implementation\Tools;

use Core\ConditionInterface;
use Core\ConditionsInterface;
use Core\RuleInterface;
use Implementation\Conditions\Providers\ConditionsProviderInterface;
use Implementation\Conditions\SimpleCondition;
use Implementation\Conditions\SimpleConditions;
use Implementation\Services\StrictValue;

class ConditionsManager
{
    /**
     * @param ConditionInterface ...$conditions
     * @return ConditionsInterface
     */
    public static function makeList(ConditionInterface ...$conditions): ConditionsInterface
    {
        return new SimpleConditions(...$conditions);
    }

    /**
     * @param ConditionsProviderInterface $provider
     * @param array $values
     * @return ConditionsInterface
     */
    public static function makeListByArray(array $values, ConditionsProviderInterface $provider): ConditionsInterface
    {
        $list = self::makeList();
        
        foreach ($values as $name => $value) {
            $list->add($provider->make($name, $value));
        }

        return $list;
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
    public static function isListCorrect(ConditionsInterface $conditions): bool
    {
        $result = true;

        $conditions->each(function ($item) use (&$result) {
            /** @var ConditionInterface $item */
            $result &= ConditionsManager::isCorrect($item);
        });

        return (bool)$result;
    }

    /**
     * @param ConditionInterface $condition
     * @return bool
     */
    public static function isCorrect(ConditionInterface $condition): bool
    {
        return $condition->followRule()->isPassed();
    }

    /**
     * @param ConditionInterface $condition
     * @return array
     */
    public static function getErrors(ConditionInterface $condition): array
    {
        return $condition->followRule()->getErrors();
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
            $result[$item->getName()] = ConditionsManager::getErrors($item);
        });

        return $result;
    }
}
