<?php declare(strict_types=1);

namespace Implementation\Services\Inputs;

use Core\ConditionsInterface;
use Implementation\Claims\ClaimedStatusInterface;
use Implementation\Claims\ClaimsInterface;
use Implementation\Services\StrictValue;
use Implementation\Services\StrictValueInterface;

class SimpleInput implements InputInterface
{
    /**
     * @var ConditionsInterface
     */
    private ConditionsInterface $conditions;

    /**
     * @var ClaimedStatusInterface
     */
    private ClaimedStatusInterface $state;

    public function __construct(ConditionsInterface $conditions, ClaimsInterface $claims)
    {
        $this->conditions = $conditions;
        $this->state = $claims->claim($conditions);
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
    public function get(string $name): StrictValueInterface
    {
        return new StrictValue($this->conditions->get($name));
    }

    /**
     * @return ClaimedStatusInterface
     */
    public function getState(): ClaimedStatusInterface
    {
        return $this->state;
    }
}
