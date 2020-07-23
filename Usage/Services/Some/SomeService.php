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

        // Some logic ...
        $this->output()
            ->put(321, 'key0')
            ->put([
                'some result 0',
                'some result 1',
            ]);
    }

    /**
     * @inheritDoc
     */
    protected function result($result): StrictValueInterface
    {
        if ($this->output()->has('key0')) {
            return Pikachu::strictValue(true);
        }
        
        return Pikachu::strictValue($this->output()->get(null, false));
    }
}
