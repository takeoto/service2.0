<?php

use Implementation\Claims\DescribableClaimsInterface;
use Implementation\Claims\SimpleClaimsDescription;
use Implementation\Services\AbstractBaseService;

class Service extends AbstractBaseService
{
    protected function inputClaims(): DescribableClaimsInterface
    {
        $claims = new SimpleClaimsDescription();
        $claims
            ->use(new ItemProviders())
            ->can('PIKACHU', new BoolRule())
            ->must(
                Make::item('PIKACHU')
                    ->mustBe(new BoolRule())
                    ->mustBe(new BoolRule())
                    ->asInt(fn($v) => (int)$v)
            )
            ->if(fn ($c) => $c->has('ROCK'))
                ->can('PIKACHU')
                ->can('PIKACHU')
                ->must('PIKACHU1')
                ->must('PIKACHU1')
            ->elseIf('PIKACHU')
                ->can('PIKACHU')
                ->can('PIKACHU')
                ->must('PIKACHU1')
                ->must('PIKACHU1')
            ->else()
                ->can('PIKACHU')
            ->endIf();
        
        return $claims;
    }


    protected function rules()
    {
        return [
            'PIKACHU0' => SomeRule::shadow(1, 23),
            'PIKACHU1',
            'PIKACHU2',
            'PIKACHU3' => [
                'flow' => Flow::make()
                    ->do()
                        ->on('EVENT_NAME')
                        ->onError()
                        ->onSuccess()
                    ->do()
                        ->on('EVENT_NAME')
                        ->onError()
                        ->onSuccess()
                    ->do()
                ,
                'normalize' => [
                    'pre' => fn($v) => trim($v),
                    'post' => fn($v) => trim($v),
                ],
                'rule' => RuleChain::shadow(
                    SomeRule::shadow(1, 23),
                    SomeRule1::shadow(['a', 'b', 'c']),
                ),
                'castInt' => fn($v) => (int)$v,
            ],
            'PIKACHU' => 'must',
            Describer::IF(
                fn() => $this->has('PIKACHU123'),
                [
                    'PIKACHU1' => 'must',
                    Describer::IF(
                        fn() => $this->has('PIKACHU123'),
                        [
                            'PIKACHU1' => 'must',
                        ]
                    ),
                ]
            ),
        ];
    }

    protected function execute()
    {
        $this->getInput()->getState()->whyIsItCantBeUse();
        // Not required condition
        if ($this->getInput()->has(SomeConditionsProvider::SECOND_PARAM_NAME)) {
            $secondValue = $this->getInput()->get(SomeConditionsProvider::SECOND_PARAM_NAME)->asInt();
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $this->getInput()->get(SomeConditionsProvider::FIRST_PARAM_NAME)->asString();

        return 'pikachu';
    }
}