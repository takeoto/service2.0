<?php declare(strict_types=1);

namespace Core;

interface RuleInterface
{
    /**
     * Check rule on passed
     * @param $value
     * @return RuleStateInterface
     */
    public function pass($value): RuleStateInterface;
}
