<?php

namespace Implementation\Services\Business;

interface ResultInterface
{
    public function getData(): StrictValueInterface;
    
    /**
     * Runtime errors
     * @return array
     */
    public function getErrors(): array;
}