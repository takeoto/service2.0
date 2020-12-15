<?php

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\StateInterface;

interface ClaimsInterface
{
    public function claimed(ConditionsInterface $conditions): StateInterface;
}