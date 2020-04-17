<?php

namespace Implementation\Services\Some;

use Core\ConditionsInterface;
use Core\ServiceResultInterface;
use Implementation\Services\AbstractService;
use Implementation\Services\SimpleServiceResult;

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
    protected function exec(ConditionsInterface $conditions): ServiceResultInterface
    {
        // Not required condition
        if ($conditions->has(SomeServiceConditions::SECOND_PARAM_NAME)) {
            $secondValue = $conditions->find(SomeServiceConditions::SECOND_PARAM_NAME)->getValue();
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $conditions->find(SomeServiceConditions::FIRST_PARAM_NAME)->getValue();

        // Some logic ...

        return new SimpleServiceResult(
            $conditions,
            ['{result data}'],
            ['{runtime errors}']
        );
    }
}
