<?php

use Implementation\Managers\ConditionsManager;
use Usage\Services\Some\SomeService;
use Usage\Services\Some\SomeServiceConditions;

class Controller
{
    public function action()
    {
        $service = new SomeService();

        // Making conditions list
        $conditions = SomeServiceConditions::base(12345)
            ->add(SomeServiceConditions::makeSecondCondition(123))
            ->add(SomeServiceConditions::makeThirdCondition('value123'));

        $dynamicParams = [1,2,3,4,5,6];

        foreach ($dynamicParams as $newParam) {
            $conditions->replace(SomeServiceConditions::makeFourthCondition($newParam));

            // Or check single condition `ConditionsManager::isCanBeUsed({newCondition})`
            if (!ConditionsManager::isListCanBeUsed($conditions)) {
                $errors = ConditionsManager::getListErrors($conditions);
                // Some logic ...
                continue;
            }

            $result = $service->handle($conditions);

            // Runtime errors
            $result->getErrors();

            // Result data
            $result->getData();
        }
    }
}
