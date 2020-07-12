<?php

namespace Core;

interface ServiceInterface
{
    /**
     * @param ConditionsInterface $conditions
     * @return mixed
     */
    public function handle(ConditionsInterface $conditions);
}
