<?php

namespace Core;

interface ServiceResultInterface
{
    /**
     * Output (result) data
     * @return mixed
     */
    public function getData();

    /**
     * Runtime errors
     * @return array
     */
    public function getErrors(): array;
}
