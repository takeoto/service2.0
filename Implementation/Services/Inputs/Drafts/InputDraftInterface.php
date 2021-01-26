<?php

namespace Implementation\Services;

use Core\ConditionsInterface;
use Implementation\Services\Inputs\InputInterface;

interface InputDraftInterface
{
    public function expose(ConditionsInterface $conditions): InputInterface;
}