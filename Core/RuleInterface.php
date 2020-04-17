<?php

namespace Core;

interface RuleInterface
{
    /**
     * Check rule on passed
     * @param $value
     * @return bool
     */
    public function isPassed($value): bool;

    /**
     * Get rule errors
     * @return array
     */
    public function getErrors(): array;
}
