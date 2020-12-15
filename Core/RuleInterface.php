<?php declare(strict_types=1);

namespace Core;

interface RuleInterface
{
    /**
     * Check rule on passed
     * @param $value
     * @return StateInterface
     */
    public function verify($value): StateInterface;
}
