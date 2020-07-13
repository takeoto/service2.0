<?php

namespace Usage\Services\Some;

use Implementation\Services\AbstractService;
use Usage\Conditions\Providers\SomeConditionsProvider;

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

        $this->output()->error('Some error!');

        // Some logic ...

        $this->output()
            ->put(321, 'key0')
            ->put([
                'some result 0',
                'some result 1',
            ]);
    }
}
