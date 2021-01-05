<?php

namespace Implementation\Services\Inputs\Drafts;

use Core\ConditionsInterface;
use Implementation\Services\InputDraftInterface;
use Implementation\Services\Inputs\InputInterface;
use Implementation\Services\Inputs\NullInput;
use Implementation\Services\Inputs\SimpleInput;
use Implementation\Services\Inputs\States\InputStateInterface;
use Implementation\Services\Inputs\States\SimpleInputState;

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