<?php

namespace Core;

interface RuleInterface
{
    /**
     * Check rule on passed
     * @param $value
     * @return RuleResultInterface
     */
    public function pass($value): RuleResultInterface;
}
