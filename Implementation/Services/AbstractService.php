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
     * Returns types
     */
    protected const RETURN_TYPE_ERROR = 'error';
    protected const RETURN_TYPE_SUCCESS = 'success';
    protected const RETURN_TYPE_FAILED_INPUT_CLIMES = 'failedIC';
    
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
            return $this->return(self::RETURN_TYPE_FAILED_INPUT_CLIMES, $this->input()->claims());
        }
        
        $this->beforeExecute();

        try {
            $execResult = $this->execute();
            $this->afterExecute($execResult);
        } catch (\Throwable $e) {
            return $this->return(self::RETURN_TYPE_ERROR, $e);
        }
        
        return $this->return(self::RETURN_TYPE_SUCCESS, $execResult);
    }

    /**
     * @param ConditionsInterface $conditions
     */
    protected function presets(ConditionsInterface $conditions): void
    {
        $this->setInput($this->describeInput()->claimed($conditions));
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
    protected function returnOnFailedInputClaims(ClaimsStateInterface $claimsState): StrictValueInterface
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
    protected function returnOnError(\Throwable $e): StrictValueInterface
    {
        throw $e;
    }

    /**
     * @param mixed $executionResult
     * @return StrictValueInterface
     */
    protected function returnOnSuccess($executionResult): StrictValueInterface
    {
        return new StrictValue($executionResult);
    }

    /**
     * @param string $type
     * @param mixed $data
     * @return StrictValueInterface
     * @throws \Throwable
     */
    protected function return(string $type, $data): StrictValueInterface
    {
        switch ($type) {
            case self::RETURN_TYPE_SUCCESS:
                return $this->returnOnSuccess($data);
            case self::RETURN_TYPE_ERROR:
                return $this->returnOnError($data);
            case self::RETURN_TYPE_FAILED_INPUT_CLIMES:
                return $this->returnOnFailedInputClaims($data);
            default:
                throw new ServiceException("Wrong return type \"$type\"!");
        }
    }

    /**
     * @return InputClaimsInterface
     */
    abstract protected function describeInput(): InputClaimsInterface;

    /**
     * Execute service logic
     * @return mixed|void
     */
    abstract protected function execute();
}