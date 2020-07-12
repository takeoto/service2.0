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
     * Pass the rule
     * @return RuleStateInterface
     */
    public function followRule(): RuleStateInterface;
}
