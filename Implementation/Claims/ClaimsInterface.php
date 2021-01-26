<?php

namespace Implementation\Claims;

use Core\ConditionsInterface;

interface ClaimsInterface
{
    public function claim(ConditionsInterface $conditions): ClaimedStatusInterface;
}