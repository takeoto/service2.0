<?php

use Implementation\Rules\IntRule;

class Service extends \Implementation\Services\AbstractService
{
    protected function inputClaims(): \Implementation\Services\InputClaimsInterface
    {
        // TODO: Implement inputClaims() method.
    }

    protected function onFailedInputClaimsResult(\Implementation\Services\ClaimsStateInterface $claimsState): \Implementation\Services\StrictValueInterface
    {
        
    }

    protected function beforeExecute(): void
    {
        
    }

    protected function execute()
    {
        $this->input()->claims()->getErrors();
        // Not required condition
        if ($this->input()->has(SomeConditionsProvider::SECOND_PARAM_NAME)) {
            $secondValue = $this->input()->get(SomeConditionsProvider::SECOND_PARAM_NAME)->asInt();
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $this->input()->get(SomeConditionsProvider::FIRST_PARAM_NAME)->asString();

        return 'pikachu';
    }

    protected function afterExecute($result): void
    {
        
    }

    protected function onErrorResult(\Throwable $e): \Implementation\Services\StrictValueInterface
    {
        
    }

    protected function onSuccessResult($executionResult): \Implementation\Services\StrictValueInterface
    {
        
    }
}