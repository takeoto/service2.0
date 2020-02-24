<?php

interface ServiceResultInterface
{
    /**
     * Input conditions
     * @return ConditionsInterface
     */
    public function getConditions(): ConditionsInterface;

    /**
     * Output (result) data
     * @return mixed
     */
    public function getData();

    /**
     * Runtime errors
     * @return array
     */
    public function getErrors(): array;
}
