<?php

class IntRule implements RuleInterface
{
    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        return is_int($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return [
            'Value must be integer',
        ];
    }
}
