<?php

namespace Implementation\Services\Inputs\Drafts;

use Core\ConditionsInterface;
use Implementation\Services\InputDraftInterface;
use Implementation\Services\Inputs\InputInterface;
use Implementation\Services\Inputs\SimpleInput;
use Implementation\Services\Inputs\States\InputStateInterface;
use Implementation\Services\Inputs\States\SimpleInputState;
use Implementation\Tools\ConditionsManager;

class SimpleInputDraft implements InputDraftInterface
{
    public function expose(ConditionsInterface $conditions): InputInterface
    {
        $conditions = $this->prepareConditions($conditions);
        
        return new SimpleInput($conditions, $this->claimed($conditions));
    }
    
    protected function claimed(ConditionsInterface $conditions): InputStateInterface
    {
        return new SimpleInputState();
    }

    /**
     * @param ConditionsInterface|null $conditions
     * @return ConditionsInterface
     */
    private function prepareConditions(?ConditionsInterface $conditions): ConditionsInterface
    {
        return $conditions ?: ConditionsManager::makeList();
    }
}