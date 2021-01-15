<?php

use Implementation\Rules\IntRule;

class Service extends \Implementation\Services\Advanced\AbstractAdvancedService
{
    protected function inputDraft(): \Implementation\Services\InputDraftInterface
    {
        $describe = new \Implementation\Services\Inputs\Claims\SimpleInputDraft();
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
    }

    protected function execute()
    {
        $this->getInput()->getState()->whyItsCantBeUsed();
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