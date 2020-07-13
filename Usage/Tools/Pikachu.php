<?php


namespace Usage\Tools;

use Implementation\Services\StrictValue;
use Implementation\Services\StrictValueInterface;

class Pikachu
{
    /**
     * @param $value
     * @return StrictValueInterface
     */
    public static function strictValue($value): StrictValueInterface
    {
        return new StrictValue($value);
    }
}