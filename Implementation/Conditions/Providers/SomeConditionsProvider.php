<?php

class SomeConditionsProvider implements ConditionsProviderInterface
{
    // Some condition names
    public const FIRST_PARAM_NAME = 'first.param';
    public const SECOND_PARAM_NAME = 'second.param';
    public const THIRD_PARAM_NAME = 'third.param';
    public const FOURTH_PARAM_NAME = 'fourth.param';

    /**
     * @inheritDoc
     */
    public function make(string $name, $value): ConditionInterface
    {
        switch ($name) {
            case self::FIRST_PARAM_NAME:
                $condition = $this->makeFirstCondition($value);
                break;
            case self::SECOND_PARAM_NAME:
                $condition = $this->makeSecondCondition($value);
                break;
            case self::THIRD_PARAM_NAME:
                $condition = $this->makeThirdCondition($value);
                break;
            case self::FOURTH_PARAM_NAME:
                $condition = $this->makeFourthCondition($value);
                break;
            default:
                throw new \Exception();
        }

        return $condition;
    }

    /**
     * @inheritDoc
     */
    public function getNames(): array
    {
        return [
            self::FIRST_PARAM_NAME,
            self::SECOND_PARAM_NAME,
            self::THIRD_PARAM_NAME,
            self::FOURTH_PARAM_NAME,
        ];
    }

    /**
     * @param $firstValue
     * @return ConditionInterface
     */
    public function makeFirstCondition($firstValue): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::FIRST_PARAM_NAME,
            $firstValue,
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
    public function makeSecondCondition($value): ConditionInterface
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
    public function makeThirdCondition($value): ConditionInterface
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
    public function makeFourthCondition($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::FOURTH_PARAM_NAME,
            $value,
            MakeRule::int()
        );
    }
}
