<?php declare(strict_types=1);

namespace Core;

interface ServiceInterface
{
    /**
     * @param ConditionsInterface $conditions
     * @return mixed
     */
    public function handle(ConditionsInterface $conditions);
}
