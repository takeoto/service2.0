<?php

namespace Implementation\Services;

use Core\ConditionInterface;
use Core\ConditionsInterface;
use Core\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    private $inputScope;
    
    private $outputScope;

    /**
     * @param ConditionsInterface $conditions
     * @return StrictValueInterface
     */
    public function handle(ConditionsInterface $conditions): StrictValueInterface
    {
        $this->reset();
        $result = null;
        
        try {
            $this->beforeExecute($conditions->filter(fn ($item) => $this->isConditionAcceptable($item), true));
            $result = $this->execute();
            $this->afterExecute($result);
        } catch (\Exception $e) {
            $this->onError($e);
        }
        
        return $this->result($result);
    }

    /**
     * Reset input and output data
     */
    private function reset(): void
    {
        $this->inputScope = null;
        $this->outputScope = null;
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
    protected function afterExecute($result): void {}

    /**
     * @param \Exception $e
     */
    protected function onError(\Exception $e): void
    {
        throw $e;
    }

    /**
     * @param mixed $result
     * @return StrictValueInterface
     */
    protected function result($result): StrictValueInterface
    {
        return new StrictValue(
            $result === null
                ? $this->output()->get()
                : $result
        );
    }

    /**
     * @return InputInterface
     */
    protected function input(): InputInterface
    {
        return $this->inputScope;
    }

    /**
     * @return OutputInterface
     */
    protected function output(): OutputInterface
    {
        return $this->outputScope;
    }

    /**
     * @param InputInterface $inputScope
     */
    protected function setInput(InputInterface $inputScope)
    {
        $this->inputScope = $inputScope;
    }

    /**
     * @param OutputInterface $outputScope
     */
    protected function setOutput(OutputInterface $outputScope)
    {
        $this->outputScope = $outputScope;
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
     * @return mixed|void
     */
    abstract protected function execute();
}