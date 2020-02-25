<?php

class BoolRule implements RuleInterface
{
    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        return is_bool($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return [
            'Value must be boolean!',
        ];
    }
}
