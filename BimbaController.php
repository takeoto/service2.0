<?php


class BimbaController
{
    public function action()
    {
        $service = new SomeService();
        

        /* Make conditions by array
        $conditions = ConditionsManager::makeListByArray([
            SomeConditionsProvider::FIRST_PARAM_NAME => 123,
            SomeConditionsProvider::SECOND_PARAM_NAME => 123,
            SomeConditionsProvider::THIRD_PARAM_NAME => 'qwe123',
        ], $manager);
         */

        $dynamicParams = [1, 2, 3, 4, 5, 6];

        foreach ($dynamicParams as $newParam) {
            $conditions->replace($manager->make(SomeConditionsProvider::FOURTH_PARAM_NAME, $newParam));

            // Or check single condition `ConditionsManager::isCanBeUsed({newCondition})`
            if (!ConditionsManager::isListCorrect($conditions)) {
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