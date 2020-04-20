<?php

namespace Implementation\Services;

use Core\ServiceResultInterface;

interface ResultInterface extends ServiceResultInterface
{
    public function getData(): StrictValueInterface;
}