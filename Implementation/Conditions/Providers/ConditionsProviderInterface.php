<?php


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