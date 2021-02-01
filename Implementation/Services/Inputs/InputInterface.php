<?php declare(strict_types=1);

namespace Implementation\Services\Inputs;

use Implementation\Claims\ClaimedStatusInterface;
use Implementation\Services\StrictValueInterface;

interface InputInterface
{
    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name): StrictValueInterface;

    /**
     * @return ClaimedStatusInterface
     */
    public function getState(): ClaimedStatusInterface;
}