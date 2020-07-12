<?php

namespace Implementation\Services\Business;

interface InputInterface extends \Implementation\Services\InputInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name): StrictValueInterface;
}