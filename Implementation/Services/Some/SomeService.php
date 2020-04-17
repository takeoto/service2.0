<?php

namespace Implementation\Services\Some;

use Core\ConditionsInterface;
use Implementation\Services\AbstractService;
use Implementation\Services\SimpleServiceResult;

class SomeService extends AbstractService
{
    /**
     * {@inheritDoc}
     */
    protected function acceptParams(): array
    {
        return [
            SomeServiceConditions::FIRST_PARAM_NAME,
            SomeServiceConditions::SECOND_PARAM_NAME,
            SomeServiceConditions::THIRD_PARAM_NAME,
            SomeServiceConditions::FOURTH_PARAM_NAME,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function exec(ConditionsInterface $conditions): ServiceResultInterface
    {
        if ($conditions->has(SomeServiceConditions::SECOND_PARAM_NAME)) {
            $conditions->find(SomeServiceConditions::SECOND_PARAM_NAME)->getValue();
            // some logic
        }

        // Throw exception if item not exists
        $value = $conditions->find(SomeServiceConditions::FIRST_PARAM_NAME)->getValue();

        return new SimpleServiceResult(
            $conditions,
            ['{result data}'],
            ['{runtime errors}']
        );
    }
}
