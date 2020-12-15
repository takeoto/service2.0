<?php declare(strict_types=1);

namespace Core;

interface StateInterface
{
    /**
     * @return bool
     */
    public function isCorrect(): bool;

    /**
     * Get rule errors
     * @return array
     */
    public function getErrors(): array;
}
