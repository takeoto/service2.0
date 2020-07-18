<?php

use Implementation\Conditions\Providers\ConditionsProvider;
use Usage\Tools\ConditionsManager;
use Usage\Conditions\Providers\SomeConditionsProvider;
use Usage\Services\Some\SomeService;

class Controller
{
    public function action()
    {
        $service = new SomeService();
        $manager = new ConditionsProvider(
            new SomeConditionsProvider(),
            new SomeConditionsProvider(),
            new SomeConditionsProvider(),
        );

        // Making conditions list
        $conditions = ConditionsManager::makeList(
            $manager->make(SomeConditionsProvider::FIRST_PARAM_NAME, 123),
            $manager->make(SomeConditionsProvider::SECOND_PARAM_NAME, 123),
            $manager->make(SomeConditionsProvider::THIRD_PARAM_NAME, 'value123'),
        );

        /* Make conditions by array
        $conditions = ConditionsManager::makeListByArray($manager, [
            SomeConditionsProvider::FIRST_PARAM_NAME => 123,
            SomeConditionsProvider::SECOND_PARAM_NAME => 123,
            SomeConditionsProvider::THIRD_PARAM_NAME => 'qwe123',
        ]);
         */

        $dynamicParams = [1, 2, 3, 4, 5, 6];

        foreach ($dynamicParams as $newParam) {
            $conditions->replace($manager->make(SomeConditionsProvider::FOURTH_PARAM_NAME, $newParam));

            // Or check single condition `ConditionsManager::isCanBeUsed({newCondition})`
            if (!ConditionsManager::isListCanBeUsed($conditions)) {
                $errors = ConditionsManager::getListErrors($conditions);
                // Some logic ...
                continue;
            }

            $result = $service->handle($conditions);;

            // Result data
            if ($result->asBool()) {
                /** @var {className} $object */
                $object = $result->asInstanceOf('{className}');
            }
        }
    }
}
