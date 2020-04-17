<?php

namespace Implementation\Services\Some;

use Core\ConditionsInterface;
use Core\ServiceResultInterface;
use Implementation\Services\AbstractService;
use Implementation\Services\SimpleServiceResult;

class SomeService extends AbstractService
{
    /**
     * @inheritDoc
     */
    protected function acceptConditions(): array
    {
        return [
            SomeConditionsProvider::FIRST_PARAM_NAME,
            SomeConditionsProvider::SECOND_PARAM_NAME,
            SomeConditionsProvider::THIRD_PARAM_NAME,
            SomeConditionsProvider::FOURTH_PARAM_NAME,
        ];
    }

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

        $this->output()->put([
            'key0' => 'some result 0',
            'key1' => 'some result 1',
        ]);
    }
}
