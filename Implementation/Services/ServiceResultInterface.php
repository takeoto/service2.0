<?php

namespace Implementation\Services;

use Core\ServiceResultInterface;
use StrictValue;

interface ResultInterface extends ServiceResultInterface
{
    public function getData(): StrictValue;
}