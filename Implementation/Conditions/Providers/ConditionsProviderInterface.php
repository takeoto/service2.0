<?php declare(strict_types=1);

namespace Implementation\Conditions\Providers;

use Core\ConditionInterface;

interface ConditionsProviderInterface
{
    /**
     * @param string $name
     * @param $value
     * @return ConditionInterface
     */
    public function make(string $name, $value): ConditionInterface;

    /**
     * @return array
     */
    public function getNames(): array;
}