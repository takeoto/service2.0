<?php

namespace Usage\Services\Some;

use Implementation\Services\AbstractService;
use Implementation\Services\StrictValueInterface;
use Usage\Conditions\Providers\SomeConditionsProvider;
use Usage\Tools\Pikachu;

class SomeService extends AbstractService
{
    /**
     * @inheritDoc
     */
    protected function execute()
    {
        // Not required condition
        if ($this->input()->has(SomeConditionsProvider::SECOND_PARAM_NAME)) {
            $secondValue = $this->input()->get(SomeConditionsProvider::SECOND_PARAM_NAME)->asInt();
            $this->output()->put(123, 'key0');
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $this->input()->get(SomeConditionsProvider::FIRST_PARAM_NAME)->asString();
        
        if ($firstValue !== 'pikachu') {
            // Force result
            return 'pikachu';
        }

        // Some logic ...
        $this->output()
            ->put(321, 'key0')
            ->put([
                'some result 0',
                'some result 1',
            ]);
    }

    protected function onError(\Exception $e): void
    {
        $this->output()->unset();
    }

    protected function result($result): StrictValueInterface
    {
        return Pikachu::strictValue(
            $this->output()->has()
                ? $this->output()->get()
                : $result
        );
    }


}
