<?php

namespace Implementation\Services;

use Core\ConditionsInterface;

interface InputClaimsInterface
{
    public function claimed(ConditionsInterface $conditions): InputInterface;
}