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
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $this->input()->get(SomeConditionsProvider::FIRST_PARAM_NAME)->asString();

        return 'pikachu';
    }
}
