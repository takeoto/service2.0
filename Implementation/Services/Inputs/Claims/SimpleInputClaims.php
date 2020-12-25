<?php

namespace Implementation\Services\Inputs\Claims;

use Core\ConditionsInterface;
use Implementation\Services\Claims\SimpleInputState;
use Implementation\Services\InputClaimsInterface;
use Implementation\Services\InputInterface;
use Implementation\Services\Inputs\NullInput;
use Implementation\Services\Inputs\SimpleInput;

class SimpleInputClaims implements InputClaimsInterface
{
    public function claimed(?ConditionsInterface $conditions): InputInterface
    {
        return $conditions === null
            ? new NullInput()
            : new SimpleInput($conditions, new SimpleInputState());
    }
}