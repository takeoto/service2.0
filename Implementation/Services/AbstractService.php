<?php

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;
use SimpleServiceResult;

abstract class AbstractService implements ServiceInterface
{
    /**
     * @var ServiceInput
     */
    private ServiceInput $scopeInput;

    /**
     * @var ServiceOutput
     */
    private ServiceOutput $scopeOutput;

    /**
     * @inheritDoc
     */
    public function handle(ConditionsInterface $conditions): ResultInterface
    {
        $this->init($conditions);
        $this->beforeExecute();
        $result = $this->execute();
        $this->afterExecute();

        return $this->executionResult($result);
    }

    /**
     * @param ConditionsInterface $conditions
     */
    private function init(ConditionsInterface $conditions): void
    {
        $conditions = $conditions->filter(function ($item) {
            /** @var \Core\ConditionInterface $item */
            return in_array($item->getName(), $this->acceptConditions());
        }, true);

        $this->setInput(new ServiceInput($conditions));
        $this->setOutput(new ServiceOutput());
    }

    /**
     * @param mixed $result
     * @return ResultInterface
     */
    protected function executionResult($result): ResultInterface
    {
        if (!is_subclass_of($result, ResultInterface::class)) {
            $result = new SimpleServiceResult(
                $this->input(),
                $result === null
                    ? $this->output()
                    : $this->output()->put($result)
            );
        }

        return $result;
    }

    protected function beforeExecute(): void
    {
        // Valid guarantee
        $this
            ->input()
            ->conditions()
            ->each(function ($item) {
                /** @var \Core\ConditionInterface $item */
                $ruleResult = $item->followRule();

                if (!$ruleResult->isPassed()) {
                    throw new \Exception(
                        'You can\'t use not correct values!'
                        . PHP_EOL
                        . 'Errors: ' . implode(',', $ruleResult->getErrors())
                    );
                }
            });
    }

    protected function afterExecute(): void
    {
    }

    /**
     * @return ServiceInput
     */
    protected function input(): ServiceInput
    {
        return $this->scopeInput;
    }

    /**
     * @return ServiceOutput
     */
    protected function output(): ServiceOutput
    {
        return $this->scopeOutput;
    }

    /**
     * @param ServiceInput $input
     */
    protected function setInput(ServiceInput $input)
    {
        $this->scopeInput = $input;
    }

    /**
     * @param ServiceOutput $output
     * @return ServiceOutput
     */
    protected function setOutput(ServiceOutput $output)
    {
        return $this->scopeOutput = $output;
    }

    /**
     * Get array of accept conditions
     * @return array
     */
    abstract protected function acceptConditions(): array;

    /**
     * Execute service logic
     * @return mixed
     */
    abstract protected function execute();
}
