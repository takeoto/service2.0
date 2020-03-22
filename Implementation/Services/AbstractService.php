<?php

abstract class AbstractService implements ServiceInterface
{
    /**
     * @inheritDoc
     */
    public function handle(ConditionsInterface $conditions): ServiceResultInterface
    {
        // Preparing service conditions
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

        // Executing service logic
        $output = $this->exec(new ServiceInput($conditions));

        return new SimpleServiceResult(
            $conditions,
            $output->getData(),
            $output->getErrors()
        );
    }

    /**
     * Get array of accept conditions
     * @return array
     */
    abstract protected function acceptConditions(): array;

    /**
     * Execute service logic
     * @param ServiceInput $conditions
     * @return ServiceOutput
     */
    abstract protected function exec(ServiceInput $conditions): ServiceOutput;
}
