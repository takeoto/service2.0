<?php

interface ServiceInterface
{
    /**
     * @param ConditionsInterface $conditions
     * @return ServiceResultInterface
     */
    public function handle(ConditionsInterface $conditions): ServiceResultInterface;
}
