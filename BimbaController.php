<?php


use Core\ConditionsInterface;
use Implementation\Tools\ConditionsManager;

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

    public function secondAction()
    {
        $flow = new Flow();
        $flow
            ->do('data filter')
                ->before()
                ->after()
                ->onError()
                ->onSucces()
            ->then()
            ->do('interface restriction')
            ->do('data transformer')
            ->do('service0 logic')
            ->do('service1 logic')
            ->do('prepare result');
        
        return $flow->resolve($_POST);
    }

    public function thirdAction()
    {
        $data = $_POST;
        
        $flow = new Flow();

        $inputFilter = function (array $data) {
            return ConditionsManager::makeList($data)->filter(fn($v, $k) => in_array($k, [
                'pikachu',
                'pikachu0',
                'pikachu1',
            ]), true);
        };
        
        $flow
            ->do($inputFilter)
                ->onError()
                ->onSucces()
            ->do('interface restriction')
            ->do('data transformer')
            ->do('service0 logic')
            ->do('service1 logic')
            ->do('prepare result');
        
        return $flow->resolve($_POST);
    }
}