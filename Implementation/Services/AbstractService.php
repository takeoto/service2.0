<?php

abstract class AbstractService implements ServiceInterface
{
    /**
     * @inheritDoc
     */
    public function handle(ConditionsInterface $conditions): ServiceResultInterface
    {
        $conditions = $conditions
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
            });

        $result = $this->exec(new ServiceConditions($conditions));

        return new SimpleServiceResult(
            $conditions,
            $result->getData(),
            $result->getErrors()
        );
    }

    /**
     * Get array of accept conditions
     * @return array
     */
    abstract protected function acceptConditions(): array;

    /**
     * Execute service logic
     * @param ServiceConditions $conditions
     * @return ServiceResult
     */
    abstract protected function exec(ServiceConditions $conditions): ServiceResult;
}
