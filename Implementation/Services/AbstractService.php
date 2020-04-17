<?php

namespace Implementation\Services;

abstract class AbstractService implements ServiceInterface
{
    /**
     * @inheritDoc
     */
    public function handle(ConditionsInterface $conditions): ServiceResultInterface
    {
        return $this->exec(
            $conditions
                // Get only conditions for service
                ->filter(function ($item) {
                    /** @var ConditionInterface $item */
                    return in_array($item->getName(), $this->acceptConditions());
                }, true)
                // Valid guarantee
                ->each(function ($item) {
                    /** @var ConditionInterface $item */
                    $ruleResult = $item->followRule();

                    if (!$ruleResult->isPassed()) {
                        throw new \Exception(
                            'You can\'t use not correct values!'
                            . PHP_EOL
                            . 'Errors: ' . implode(',', $ruleResult->getErrors())
                        );
                    }
                })
        );
    }

    /**
     * Get array of accept conditions
     * @return array
     */
    abstract protected function acceptConditions(): array;

    /**
     * Execute service logic
     * @param ConditionsInterface $conditions
     * @return ServiceResultInterface
     */
    abstract protected function exec(ConditionsInterface $conditions): ServiceResultInterface;
}
