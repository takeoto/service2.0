<?php

abstract class AbstractService implements ServiceInterface
{
    /**
     * @var ServiceInput
     */
    private ServiceInput $in;

    /**
     * @var ServiceOutput
     */
    private ServiceOutput $out;

    /**
     * @inheritDoc
     */
    public function handle(ConditionsInterface $conditions): ResultInterface
    {
        $this->init($conditions);
        $this->beforeExecute();
        $result = $this->execute();
        $this->afterExcute();

        return $this->executionResult($result);
    }

    /**
     * @param ConditionsInterface $conditions
     */
    private function init(ConditionsInterface $conditions): void
    {
        $conditions = $conditions->filter(function ($item) {
            /** @var ConditionInterface $item */
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
        $this->in->conditions()->each(function ($item) {
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
    }

    protected function afterExcute(): void {}

    /**
     * @return ServiceInput
     */
    protected function input(): ServiceInput
    {
        return $this->in;
    }

    /**
     * @return ServiceOutput
     */
    protected function output(): ServiceOutput
    {
        return $this->out;
    }

    /**
     * @param ServiceInput $in
     */
    protected function setInput(ServiceInput $in)
    {
        $this->in = $in;
    }

    /**
     * @param ServiceOutput $out
     * @return ServiceOutput
     */
    protected function setOutput(ServiceOutput $out)
    {
        return $this->out = $out;
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
