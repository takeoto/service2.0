<?php

namespace Implementation\Services;

use Core\ConditionsInterface;

interface InputDraftInterface
{
    public function expose(?ConditionsInterface $conditions): InputInterface;
}