<?php

class SomeService extends AbstractService
{
    /**
     * @inheritDoc
     */
    protected function acceptConditions(): array
    {
        return [
            SomeServiceConditions::FIRST_PARAM_NAME,
            SomeServiceConditions::SECOND_PARAM_NAME,
            SomeServiceConditions::THIRD_PARAM_NAME,
            SomeServiceConditions::FOURTH_PARAM_NAME,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function exec(ServiceConditions $conditions): ServiceResult
    {
        // Not required condition
        if ($conditions->has(SomeServiceConditions::SECOND_PARAM_NAME)) {
            $secondValue = $conditions->getValue(SomeServiceConditions::SECOND_PARAM_NAME)->asInt();
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $conditions->getValue(SomeServiceConditions::FIRST_PARAM_NAME)->asString();

        // Some logic ...

        return new ServiceResult(
            ['{result data}'],
            ['{runtime errors}']
        );
    }
}
