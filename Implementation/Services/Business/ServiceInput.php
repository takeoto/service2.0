<?php

namespace Implementation\Services\Business;

use Core\ConditionsInterface;
use Implementation\Tools\Pikachu;

class ServiceInput implements InputInterface
{
    /**
     * @var ConditionsInterface
     */
    private $conditions;

    public function __construct(ConditionsInterface $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return $this->conditions->has($name);
    }

    /**
     * @param string $name
     * @return StrictValueInterface
     */
    public function get(string $name): StrictValueInterface
    {
        return Pikachu::strictValue($this->conditions->find($name)->getValue());
    }
}
