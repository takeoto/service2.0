<?php

namespace Implementation\Services\Business;

use Implementation\Services\InputInterface as BaseInputInterface;

interface InputInterface extends BaseInputInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name): StrictValueInterface;
}