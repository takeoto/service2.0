<?php

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;
use ServiceResult;

abstract class AbstractService implements ServiceInterface
{
    /**
     * @var InputInterface
     */
    private InputInterface $scopeInput;

    /**
     * @var OutputInterface
     */
    private OutputInterface $scopeOutput;

    /**
     * @inheritDoc
     */
    final public function handle(ConditionsInterface $conditions): ResultInterface
    {
        $conditions = $conditions->filter(function ($item) {
            /** @var \Core\ConditionInterface $item */
            return in_array($item->getName(), $this->acceptConditions());
        }, true);

        $this->scopeInput = new ServiceInput($conditions);
        $this->scopeOutput = new ServiceOutput();

        $this->beforeExecute($conditions);
        $result = $this->execute();
        $this->afterExecute($result);

        return $this->executionResult($result);
    }

    /**
     * @param mixed $result
     * @return ResultInterface
     */
    protected function executionResult($result): ResultInterface
    {
        if (!is_subclass_of($result, ResultInterface::class)) {
            $result = new ServiceResult(
                $this->input(),
                $result === null
                    ? $this->output()
                    : $this->output()->put($result)
            );
        }

        return $result;
    }

    /**
     * Before execution
     * @param ConditionsInterface $conditions
     */
    protected function beforeExecute(ConditionsInterface $conditions): void
    {
        // Valid guarantee
        $conditions->each(function ($item) {
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

    /**
     * After execution
     * @param mixed $result
     */
    protected function afterExecute($result): void
    {
    }

    /**
     * @return InputInterface
     */
    protected function input(): InputInterface
    {
        return $this->scopeInput;
    }

    /**
     * @return OutputInterface
     */
    protected function output(): OutputInterface
    {
        return $this->scopeOutput;
    }

    /**
     * @param InputInterface $input
     */
    protected function setInput(InputInterface $input)
    {
        $this->scopeInput = $input;
    }

    /**
     * @param OutputInterface $output
     * @return OutputInterface
     */
    protected function setOutput(OutputInterface $output)
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
