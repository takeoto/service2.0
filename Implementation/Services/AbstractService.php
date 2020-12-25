<?php declare(strict_types=1);

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;
use Implementation\Services\Exceptions\ServiceException;
use Implementation\Services\Inputs\Claims\SimpleInputClaims;

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
     * @var InputInterface|null
     */
    private ?InputInterface $claimedInput = null;

    /**
     * @param ConditionsInterface|null $conditions
     * @return StrictValueInterface
     * @throws \Throwable
     */
    public function handle(?ConditionsInterface $conditions = null): StrictValueInterface
    {
        $this->presets($conditions);
        
        if (static::RETURN_ON_FAILED_INPUT_CLAIMS && !$this->input()->state()->isCanBeUsed()) {
            return $this->return(self::RETURN_TYPE_FAILED_INPUT_CLIMES, $this->input()->state());
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
     * @param ConditionsInterface|null $conditions
     */
    protected function presets(?ConditionsInterface $conditions): void
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
     * @param InputStateInterface $claimsState
     * @return StrictValueInterface
     * @throws ServiceException
     */
    protected function returnOnFailedInputClaims(InputStateInterface $claimsState): StrictValueInterface
    {
        throw new ServiceException('Service input errors: ' . implode(',', $claimsState->whyItsCantBeUsed()));
    }

    /**
     * Before execution
     */
    protected function beforeExecute(): void
    {
    }

    /**
     * After execution
     * @param mixed $result
     */
    protected function afterExecute($result): void
    {
    }

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
    protected function describeInput(): InputClaimsInterface
    {
        return new SimpleInputClaims();
    }

    /**
     * Execute service logic
     * @return mixed|void
     */
    abstract protected function execute();
}
