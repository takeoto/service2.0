<?php

namespace Implementation\Services;

use Core\ConditionInterface;
use Core\ConditionsInterface;
use Core\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    private $inputScope;
    
    private $defaultResult = null;

    /**
     * @param ConditionsInterface $conditions
     * @return StrictValueInterface
     */
    public function handle(ConditionsInterface $conditions): StrictValueInterface
    {
        $this->reset();
        $result = $this->defaultResult;
        
        try {
            $this->beforeExecute($conditions->filter(fn ($item) => $this->isConditionAcceptable($item), true));
            $result = $this->execute();
            $this->afterExecute($result);
        } catch (\Throwable $e) {
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
    }

    /**
     * Before execution
     * @param ConditionsInterface $conditions
     */
    protected function beforeExecute(ConditionsInterface $conditions): void
    {
        $this->setInput(new ServiceInput($conditions));
    }

    /**
     * After execution
     * @param mixed $result
     */
    protected function afterExecute($result): void {}

    /**
     * @param \Throwable $e
     */
    protected function onError(\Throwable $e): void
    {
        throw $e;
    }

    /**
     * @param mixed $result
     * @return StrictValueInterface
     */
    protected function result($result): StrictValueInterface
    {
        return new StrictValue($result);
    }

    /**
     * @return InputInterface
     */
    protected function input(): InputInterface
    {
        return $this->inputScope;
    }

    /**
     * @param InputInterface $inputScope
     */
    protected function setInput(InputInterface $inputScope)
    {
        $this->inputScope = $inputScope;
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