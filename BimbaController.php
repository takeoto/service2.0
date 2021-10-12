<?php


use Core\ConditionsInterface;
use Implementation\Conditions\RawCondition;
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
        
        $conditions->find(SomeConditionsProvider::FIRST_PARAM_NAME)->getValue()->asInt();
        
         */

        $conditions = ConditionsManager::makeList($_POST);
        $dynamicParams = [1, 2, 3, 4, 5, 6];
        $claims = $service->getClaims();

        foreach ($dynamicParams as $newParam) {
            $conditions->add('PIKACHU', $newParam);
            $status = $claims->claim($conditions);
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
        
        $result = $describe->claime($_POST);
        
        $typeControl = new TypeControl();
        $typeControl->cast('PIKACHU', );
    }

    public function extendableRuleConcept()
    {
        $rule = new Rule0();
        $rule2 = new Rule1();

        $rule->extend($rule2);
        $rule->verify($value);
        
        #########################
        
        $options = ['max' => '10', 'min' => 0];
        $rule = new Rule0($options);

        $options['max'] = '1';
        $rule->extend($options);
        $rule->verify($value);
        
        #########################
//        
//        $rule = new Rule0();
//        $options = ['max' => '10', 'min' => 0];
//        $rule->verify($value, $options);
//        
//        $options['max'] = '1';
//        $rule->verify($value, $options);
//        
        ########################
        
        $rule = new Rule0();
        $rule2 = new Rule1();

        $extendedRule = $rule->extend($rule2);
        $extendedRule->verify($value);

        #########################
        
        ########################
        
        $rule = new Rule0();
        $rule2 = new Rule1();

        $extendedRule = $rule->extend($rule2);
        $extendedRule->verify($value);

        #########################
    }

    public function conditionsConcept()
    {
        $rule = new Rule0();
        $value = new Value();
        $rawData = 'PIKACHU';
        
        $condition = new Condition($name, $rawData, $rule, $value);
        ####
        
        $raw = new ConditionRaw();
        $lazyStringRule = new LazyStringRule('{some params}');
        
        $raw
            ->setCaster(
                (new CaseterBuilder())
                    ->cast(new IntCaster())
                    ->cast([Value::STRING, fn($v) => (string)$v])
            )
                
            ->rule()
                ->bind(new IntRule())
                ->bind(
                    $lazyStringRule->with('some params')
                )
                ->extend($lazyStringRule->with('some params'))
        ;
        
        # condition [rule, type]
        
        $raw = new RawCondition();
        $raw->setName('PIKACHU')
            ->setValue('value')
            ->buildValue()
                ->cast(new IntCaster())
                ->cast([Value::STRING, fn($v) => (string)$v]);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
}