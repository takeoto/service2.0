<?php


use Core\ConditionsInterface;
use Implementation\Tools\ConditionsManager;

class BimbaController
{
    public function action()
    {
        $service = new Service();

        /* Make conditions by array
        $conditions = ConditionsManager::makeListByArray([
            SomeConditionsProvider::FIRST_PARAM_NAME => 123,
            SomeConditionsProvider::SECOND_PARAM_NAME => 123,
            SomeConditionsProvider::THIRD_PARAM_NAME => 'qwe123',
        ], $manager);
         */

        $conditions = ConditionsManager::makeList($_POST);
        $dynamicParams = [1, 2, 3, 4, 5, 6];

        foreach ($dynamicParams as $newParam) {
            $conditions->add('PIKACHU', $newParam);
            $result = $service->handle($conditions);

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

    public function fourthAction()
    {
        $describe = new SimpleInputDraft();
        $describe
            ->can('PIKACHU')
            ->must('PIKACHU1')
            ->if(fn ($c) => $c->has('ROCK'))
                ->can('PIKACHU')
                ->can('PIKACHU')
                ->must('PIKACHU1')
                ->must('PIKACHU1')
            ->elseIf()
                ->can('PIKACHU')
                ->can('PIKACHU')
                ->must('PIKACHU1')
                ->must('PIKACHU1')
            ->else()
                ->can('PIKACHU')
            ->endIf()
        ;
        
        $typeControl = new TypeControl();
        $typeControl->cast('PIKACHU', )
    }
}