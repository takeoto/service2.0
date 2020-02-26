<?php

class SomeServiceConditions
{
    // Some condition names
    public const FIRST_PARAM_NAME = 'first.param';
    public const SECOND_PARAM_NAME = 'second.param';
    public const THIRD_PARAM_NAME = 'third.param';
    public const FOURTH_PARAM_NAME = 'fourth.param';

    /**
     * Make base conditions for "SomeService"
     * @param $firstValue
     * @return ConditionsInterface
     */
    public static function base($firstValue): ConditionsInterface
    {
        return ConditionsManager::makeList(
            ConditionsManager::makeOne(
                self::FIRST_PARAM_NAME,
                $firstValue,
                MakeRule::entityExists(
                    '{entityManager}',
                    '{className}'
                )
            )
        );
    }

    /**
     * Make "second" condition for service
     * @param $value
     * @return ConditionInterface
     */
    public static function makeSecondCondition($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::SECOND_PARAM_NAME,
            $value,
            MakeRule::chain(
                MakeRule::int(),
                MakeRule::moreThen(10)
            )
        );
    }

    /**
     * Make "third" condition for service
     * @param $value
     * @return ConditionInterface
     */
    public static function makeThirdCondition($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::THIRD_PARAM_NAME,
            $value,
            MakeRule::arrayOf([
                'value1',
                'value2',
            ])
        );
    }

    /**
     * Make "fourth" condition for service
     * @param $value
     * @return ConditionInterface
     */
    public static function makeFourthCondition($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::FOURTH_PARAM_NAME,
            $value,
            MakeRule::int()
        );
    }
}
