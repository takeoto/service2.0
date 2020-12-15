<?php

use Implementation\Rules\IntRule;

class Service
{
    public function claims()
    {
        return InputClaims::make()
            ->must('PIKACHU_NAME', IntRule::class, [
                IntRule::PIKA_PARAM => '123PIKA',
            ])
            ->must('PIKACHU_NAME', IntRule::class, [
                IntRule::PIKA_PARAM => '123PIKA',
            ])
            ->can()
            ->resolve();
    }

    public function beforeExecute($conditions)
    {
        $this->setInput();
    }
    
    public function execute()
    {
        // Not required condition
        if ($this->input()->has(SomeConditionsProvider::SECOND_PARAM_NAME)) {
            $secondValue = $this->input()->get(SomeConditionsProvider::SECOND_PARAM_NAME)->asInt();
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $this->input()->get(SomeConditionsProvider::FIRST_PARAM_NAME)->asString();

        return 'pikachu';
    }

    public function afterExecute($result)
    {
        
    }

    public function onErrorResult($exception)
    {
        
    }

    public function onSuccessResult($result)
    {
        
    }
}