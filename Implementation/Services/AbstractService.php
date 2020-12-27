<?php declare(strict_types=1);

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;
use Implementation\Services\Exceptions\ServiceException;

abstract class AbstractService implements ServiceInterface
{
    /**
     * Stop execution on input claims fail
     */
    protected const RETURN_ON_INPUT_FAILED = true;

    /**
     * Returns types
     */
    protected const RETURN_TYPE_ERROR = 'error';
    protected const RETURN_TYPE_SUCCESS = 'success';
    protected const RETURN_TYPE_ACCESS_DENIED = 'failedIC';

    /**
     * @var InputInterface
     */
    private InputInterface $input;

    /**
     * @param ConditionsInterface|null $conditions
     * @return mixed
     * @throws \Throwable
     */
    public function handle(?ConditionsInterface $conditions = null)
    {
        $this->presets($conditions === null ? null : clone $conditions);
        
        if (!$this->hasAccess()) {
            return $this->return(self::RETURN_TYPE_ACCESS_DENIED);
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
        $this->setInput($this->inputDraft()->expose($conditions));
    }

    /**
     * @return bool
     */
    private function hasAccess(): bool
    {
        return !static::RETURN_ON_INPUT_FAILED || !$this->getInput()->getState()->isCanBeUsed();
    }

    /**
     * @param InputInterface $input
     */
    final protected function setInput(InputInterface $input): void
    {
        $this->input = $input;
    }

    /**
     * @return InputInterface
     */
    final protected function getInput(): InputInterface
    {
        return $this->input;
    }

    /**
     * @return mixed
     * @throws ServiceException
     */
    protected function returnOnAccessDenied()
    {
        throw new ServiceException(
            'Service input errors: ' .
            implode(',', $this->getInput()->getState()->whyItsCantBeUsed())
        );
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
    protected function returnOnError(\Throwable $e)
    {
        throw $e;
    }

    /**
     * @param mixed $executionResult
     * @return mixed
     */
    protected function returnOnSuccess($executionResult)
    {
        return $executionResult;
    }

    /**
     * @param string $type
     * @param mixed $data
     * @return mixed
     * @throws \Throwable
     */
    protected function return(string $type, $data = null)
    {
        switch ($type) {
            case self::RETURN_TYPE_SUCCESS:
                $result = $this->returnOnSuccess($data);
                break;
            case self::RETURN_TYPE_ERROR:
                $result = $this->returnOnError($data);
                break;
            case self::RETURN_TYPE_ACCESS_DENIED:
                $result = $this->returnOnAccessDenied();
                break;
            default:
                throw new ServiceException("Wrong return type \"$type\"!");
        }
        
        return $result;
    }

    /**
     * @return InputDraftInterface
     */
    abstract protected function inputDraft(): InputDraftInterface;

    /**
     * Execute service logic
     * @return mixed|void
     */
    abstract protected function execute();
}
