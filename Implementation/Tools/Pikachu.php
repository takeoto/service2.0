<?php


namespace Implementation\Tools;

use Implementation\Services\Business\StrictValue;
use Implementation\Services\Business\StrictValueInterface;

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