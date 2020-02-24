<?php

class SomeService extends AbstractService
{
    public const FIRST_PARAM_NAME = 'first.param';
    public const SECOND_PARAM_NAME = 'second.param';
    public const THIRD_PARAM_NAME = 'third.param';
    public const FOURTH_PARAM_NAME = 'fourth.param';

    /**
     * {@inheritDoc}
     */
    protected function acceptParams(): array
    {
        return [
            self::FIRST_PARAM_NAME,
            self::SECOND_PARAM_NAME,
            self::THIRD_PARAM_NAME,
            self::FOURTH_PARAM_NAME,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function exec(ConditionsInterface $conditions): ServiceResultInterface
    {
        if ($conditions->has(self::SECOND_PARAM_NAME)) {
            $conditions->find(self::SECOND_PARAM_NAME)->getName();
            // some logic
        }

        // Throw exception if item not exists
        $value = $conditions->find(self::FIRST_PARAM_NAME)->getValue();

        return new SimpleServiceResult(
            $conditions,
            ['{result data}'],
            ['{runtime errors}']
        );
    }
}
