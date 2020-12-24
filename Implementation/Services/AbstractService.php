<?php declare(strict_types=1);

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;
use Core\RuleStateInterface;

abstract class AbstractService implements ServiceInterface
{
    /**
     * Stop execution on input claims fail 
     */
    protected const RETURN_ON_FAILED_INPUT_CLAIMS = true;
    
    /**
     * @var InputInterface
     */
    private InputInterface $claimedInput;

    /**
     * @param ConditionsInterface $conditions
     * @return StrictValueInterface
     * @throws \Throwable
     */
    public function handle(ConditionsInterface $conditions): StrictValueInterface
    {
        $this->presets($conditions);

        if (static::RETURN_ON_FAILED_INPUT_CLAIMS && !$this->input()->claims()->isCorrect()) {
            return $this->onFailedInputClaimsResult($this->input()->claims());
        }
        
        $this->beforeExecute();

        try {
            $execResult = $this->execute();
            $this->afterExecute($execResult);
        } catch (\Throwable $e) {
            return $this->onErrorResult($e);
        }
        
        return $this->onSuccessResult($execResult);
    }

    /**
     * @param ConditionsInterface $conditions
     */
    protected function presets(ConditionsInterface $conditions): void
    {
        $this->setInput($this->inputClaims()->claimed($conditions));
    }

    /**
     * @param InputInterface $input
     */
    final protected function setInput(InputInterface $input): void
    {
        $this->claimedInput = $input;
    }

    /**
     * @return InputInterface
     */
    final protected function input(): InputInterface
    {
        return $this->claimedInput;
    }

    /**
     * @param ClaimsStateInterface $claimsState
     * @return StrictValueInterface
     *@throws ServiceException
     */
    protected function onFailedInputClaimsResult(ClaimsStateInterface $claimsState): StrictValueInterface
    {
        throw new ServiceException('Service input errors: ' . implode(',', $claimsState->getErrors()));
    }

    /**
     * Before execution
     */
    protected function beforeExecute(): void {}

    /**
     * After execution
     * @param mixed $result
     */
    protected function afterExecute($result): void {}

    /**
     * @param \Throwable $e
     * @return mixed
     */
    protected function onErrorResult(\Throwable $e): StrictValueInterface
    {
        throw $e;
    }

    /**
     * @param mixed $executionResult
     * @return StrictValueInterface
     */
    protected function onSuccessResult($executionResult): StrictValueInterface
    {
        return new StrictValue($executionResult);
    }

    /**
     * @return InputClaimsInterface
     */
    abstract protected function inputClaims(): InputClaimsInterface;

    /**
     * Execute service logic
     * @return mixed|void
     */
    abstract protected function execute();
}