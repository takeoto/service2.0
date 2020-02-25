<?php

class Controller
{
    public function action()
    {
        $srv = new SomeService();

        // Making conditions list
        $conditions = SomeServiceConditions::base(12345)
            ->add(SomeServiceConditions::makeSecondCondition(123))
            ->add(SomeServiceConditions::makeThirdCondition('value123'));

        $dynamicParams = [1,2,3,4,5,6];

        if (!ConditionsManager::isListCanBeUsed($conditions)) {
            $errors = ConditionsManager::getListErrors($conditions);
            // Some logic ...
            return;
        }

        foreach ($dynamicParams as $newParam) {
            $conditions->replace($newCondition = SomeServiceConditions::makeFourthCondition($newParam));

            if (!ConditionsManager::isCanBeUsed($newCondition)) {
                continue;
            }

            $result = $srv->handle($conditions);

            // Runtime errors
            $result->getErrors();

            // Result data
            $result->getData();
        }
    }
}
