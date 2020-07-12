<?php

namespace Usage\Conditions\Providers;

use Core\ConditionInterface;
use Implementation\Conditions\Providers\AbstractConditionsProvider;
use Implementation\Tools\ConditionsManager;
use Implementation\Tools\MakeRule;

class SomeConditionsProvider extends AbstractConditionsProvider
{
    // Some condition names
    public const FIRST_PARAM_NAME = 'some.first';
    public const SECOND_PARAM_NAME = 'some.second';
    public const THIRD_PARAM_NAME = 'some.third';
    public const FOURTH_PARAM_NAME = 'some.fourth';

    /**
     * @param $value
     * @return ConditionInterface
     */
    public function makeFirst($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::FIRST_PARAM_NAME,
            $value,
            MakeRule::entityExists(
                '{entityManager}',
                '{className}'
            )
        );
    }

    /**
     * Make "second" condition for service
     * @param $value
     * @return ConditionInterface
     */
    public function makeSecond($value): ConditionInterface
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
    public function makeThird($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::THIRD_PARAM_NAME,
            $value,
            MakeRule::oneOf([
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
    public function makeFourth($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::FOURTH_PARAM_NAME,
            $value,
            MakeRule::int()
        );
    }
}
