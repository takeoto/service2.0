<?php

namespace Implementation\Services;

use Core\ConditionInterface;
use Core\ConditionsInterface;
use Core\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    private $input;
    
    private $output;

    /**
     * @param ConditionsInterface $conditions
     * @return StrictValueInterface
     */
    public function handle(ConditionsInterface $conditions): StrictValueInterface
    {
        $this->reset();
        $this->beforeExecute($conditions->filter(fn ($item) => $this->isConditionAcceptable($item), true));
        $result = $this->execute();
        $this->afterExecute($result);
        
        return $this->result();
    }

    /**
     * Reset input and output data
     */
    private function reset(): void
    {
        $this->input = null;
        $this->output = null;
    }

    /**
     * Before execution
     * @param ConditionsInterface $conditions
     */
    protected function beforeExecute(ConditionsInterface $conditions): void
    {
        $this->setInput(new ServiceInput($conditions));
        $this->setOutput(new ServiceOutput());
    }

    /**
     * After execution
     * @param mixed $result
     */
    protected function afterExecute($result): void
    {
        if ($result !== null) {
            $this->output()->put($result);
        }
    }

    /**
     * @return InputInterface
     */
    protected function input(): InputInterface
    {
        return $this->input;
    }

    /**
     * @return OutputInterface
     */
    protected function output(): OutputInterface
    {
        return $this->output;
    }

    /**
     * @param InputInterface $input
     */
    protected function setInput(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * @param OutputInterface $output
     */
    protected function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param ConditionInterface $condition
     * @return bool
     */
    protected function isConditionAcceptable(ConditionInterface $condition): bool
    {
        return $condition->followRule()->isPassed();
    }

    /**
     * @return StrictValueInterface
     */
    abstract protected function result(): StrictValueInterface;

    /**
     * Execute service logic
     * @return mixed
     */
    abstract protected function execute();
}