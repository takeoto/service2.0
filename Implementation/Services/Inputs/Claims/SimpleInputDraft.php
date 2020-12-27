<?php

namespace Implementation\Services\Inputs\Claims;

use Core\ConditionsInterface;
use Implementation\Services\Claims\SimpleInputState;
use Implementation\Services\InputDraftInterface;
use Implementation\Services\InputInterface;
use Implementation\Services\Inputs\NullInput;
use Implementation\Services\Inputs\SimpleInput;
use Implementation\Services\InputStateInterface;

class SimpleInputDraft implements InputDraftInterface
{
    public function expose(?ConditionsInterface $conditions): InputInterface
    {
        return $conditions === null
            ? new NullInput($this->claimed($conditions))
            : new SimpleInput($conditions, $this->claimed($conditions));
    }
    
    protected function claimed(?ConditionsInterface $conditions): InputStateInterface
    {
        return new SimpleInputState();
    }
}