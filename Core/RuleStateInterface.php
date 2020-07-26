<?php

namespace Core;

interface RuleStateInterface
{
    /**
     * @return bool
     */
    public function isPassed(): bool;

    /**
     * Get rule errors
     * @return array
     */
    public function getErrors(): array;
}
