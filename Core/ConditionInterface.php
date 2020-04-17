<?php

namespace Core;

interface ConditionInterface
{
    /**
     * Get condition unique name
     * @return string
     */
    public function getName(): string;

    /**
     * Get condition value
     * @return mixed
     */
    public function getValue();

    /**
     * Get condition rule
     * @return RuleInterface|null
     */
    public function getRule(): RuleInterface;
}
