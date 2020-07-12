<?php

namespace Implementation\Services\Business;

use Implementation\Services\OutputInterface as BaseOutputInterface;

interface OutputInterface extends BaseOutputInterface
{
    /**
     * @param string $message
     * @param string|null $key
     * @return self
     */
    public function error(string $message, string $key = null): self;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return array
     */
    public function getErrors(): array;
}