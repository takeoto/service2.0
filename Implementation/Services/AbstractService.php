<?php declare(strict_types=1);

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
        $conditions = $conditions->filter(function ($item) { return $this->isConditionAcceptable($item); }, true);
        $this->reset($conditions);
        $result = $this->defaultResult;
        
        try {
            $this->beforeExecute($conditions);
            $result = $this->execute();
            $this->afterExecute($result);
        } catch (\Throwable $e) {
            $this->onError($e);
        }
        
        return $this->result($result);
    }

    /**
     * Reset input and output data
     * @param ConditionsInterface $conditions
     */
    private function reset(ConditionsInterface $conditions): void
    {
        $this->inputScope = new ServiceInput($conditions);
    }

    /**
     * Before execution
     * @param ConditionsInterface $conditions
     */
    protected function beforeExecute(ConditionsInterface $conditions): void {}

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
        if ($this->inputScope === null) {
            throw new \LogicException('You must set input object before use!');
        }
        
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