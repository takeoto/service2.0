<?php declare(strict_types=1);

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    private $inputScope;

    /**
     * @param ConditionsInterface $conditions
     * @return StrictValueInterface
     * @throws ServiceException
     */
    public function handle(ConditionsInterface $conditions): StrictValueInterface
    {
        $this->claimedConditions($conditions);
        $this->reset($conditions);
        $this->beforeExecute($conditions);

        try {
            $execResult = $this->execute();
            $this->afterExecute($execResult);
        } catch (\Throwable $e) {
            return $this->onError($e);
        }
        
        return $this->onSuccess($execResult);
    }

    /**
     * @param ConditionsInterface $conditions
     */
    private function reset(ConditionsInterface $conditions): void
    {
        $this->setInput(new ServiceInput($conditions));
    }

    /**
     * @param ConditionsInterface $conditions
     */
    protected function claimedConditions(ConditionsInterface $conditions): void
    {
        $conditionsState = $this->claims()->claimed($conditions);

        if (!$conditionsState->isCorrect()) {
            throw new ServiceException('Service input errors: ' . implode(',', $conditionsState->getErrors()));
        }
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
     * @param $executionResult
     * @return StrictValueInterface
     */
    protected function prepareResult($executionResult): StrictValueInterface
    {
        return new StrictValue($executionResult);
    }

    /**
     * @param \Throwable $e
     * @return mixed
     */
    protected function onError(\Throwable $e): StrictValueInterface
    {
        throw $e;
    }

    /**
     * @param mixed $executionResult
     * @param bool $afterError
     * @return StrictValueInterface
     */
    protected function onSuccess($executionResult): StrictValueInterface
    {
        return $this->prepareResult($executionResult);
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
    final protected function setInput(InputInterface $inputScope)
    {
        $this->inputScope = $inputScope;
    }

    /**
     * @return ClaimsInterface
     */
    abstract protected function claims(): ClaimsInterface;

    /**
     * Execute service logic
     * @return mixed|void
     */
    abstract protected function execute();
}