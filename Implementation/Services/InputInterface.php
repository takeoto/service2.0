<?php declare(strict_types=1);

namespace Implementation\Services;

interface InputInterface
{
    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * @param string $name
     * @return StrictValueInterface
     */
    public function get(string $name): StrictValueInterface;

    /**
     * @return InputStateInterface
     */
    public function state(): InputStateInterface;
}