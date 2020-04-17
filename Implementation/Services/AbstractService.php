<?php

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;
use Core\ServiceResultInterface;

abstract class AbstractService implements ServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function handle(ConditionsInterface $conditions): ServiceResultInterface
    {
        return $this->exec(
            $conditions
                ->filter(function ($item) {
                    /** @var \Core\ConditionInterface $item */
                    return in_array($item->getName(), $this->acceptParams());
                }, true)
                ->each(function ($item) {
                    /** @var \Core\ConditionInterface $item */
                    if (!$item->getRule()->isPassed($item->getValue())) {
                        throw new \Exception('You can\'t use not correct values!');
                    }
                })
        );
    }

    /**
     * Get array of accept params
     * @return array
     */
    abstract protected function acceptParams(): array;

    /**
     * Execute service logic
     * @param ConditionsInterface $conditions
     * @return ServiceResultInterface
     */
    abstract protected function exec(ConditionsInterface $conditions): ServiceResultInterface;
}
