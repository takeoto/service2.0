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
        $this->beforeExecute($conditions->filter(fn ($item) => $this->isConditionAcceptable($item), true));
        
        return $this->processResult($this->execute());
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
     * @param mixed $result
     * @return StrictValueInterface
     */
    protected function processResult($result): StrictValueInterface
    {
        if ($result !== null) {
            $this->output()->put($result);
        }
        
        return new StrictValue($this->output()->get());
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
     * Execute service logic
     * @return mixed
     */
    abstract protected function execute();
}