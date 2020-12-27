<?php declare(strict_types=1);

namespace Implementation\Services\Inputs;

use Core\ConditionsInterface;
use Implementation\Services\InputInterface;
use Implementation\Services\InputStateInterface;
use Implementation\Services\StrictValue;
use Implementation\Services\StrictValueInterface;

class SimpleInput implements InputInterface
{
    /**
     * @var ConditionsInterface
     */
    private $conditions;
    
    /**
     * @var InputStateInterface
     */
    private InputStateInterface $state;

    public function __construct(ConditionsInterface $conditions, InputStateInterface $state)
    {
        $this->conditions = $conditions;
        $this->state = $state;
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
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->conditions->get($name);
    }

    /**
     * @return InputStateInterface
     */
    public function getState(): InputStateInterface
    {
        return $this->state;
    }
}
