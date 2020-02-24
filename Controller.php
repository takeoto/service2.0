<?php

class Controller
{
    public function action()
    {
        $srv = new SomeService();

        // Making conditions list
        $conditions = ConditionsManager::makeList(
            ConditionsManager::makeOne(SomeService::FIRST_PARAM_NAME, 'value123', MakeRule::arrayOf([
                'value1',
                'value2',
            ])),
            ConditionsManager::makeOne(SomeService::SECOND_PARAM_NAME, 123, MakeRule::chain(
                MakeRule::int(),
                MakeRule::moreThen(10)
            )),
            ConditionsManager::makeOne(SomeService::SECOND_PARAM_NAME, 123456, MakeRule::entityExists(
                '{entityManager}',
                '{className}'
            ))
            //, ... condition
        );

        $dynamicParams = [1,2,3,4,5,6];

        foreach ($dynamicParams as $newParam) {
            $conditions->replace(
                ConditionsManager::makeOne(
                    SomeService::FOURTH_PARAM_NAME,
                    $newParam,
                    MakeRule::int()
                )
            );

            if (!ConditionsManager::isListCanBeUsed($conditions)) {
                $errors = ConditionsManager::getListErrors($conditions);
                // Some logic ...
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
