<?php declare(strict_types=1);

namespace Implementation\Services;

use Core\ConditionsInterface;
use Core\ServiceInterface;
use Implementation\Services\Exceptions\ServiceException;

abstract class AbstractService implements ServiceInterface
{
    /**
     * Returns types
     */
    protected const RETURN_TYPE_ERROR = 'RETURN_TYPE_ERROR';
    protected const RETURN_TYPE_SUCCESS = 'RETURN_TYPE_SUCCESS';
    protected const RETURN_TYPE_ACCESS_DENIED = 'RETURN_TYPE_ACCESS_DENIED';

    /**
     * @param ConditionsInterface|null $conditions
     * @return mixed
     * @throws \Throwable
     */
    public function handle(?ConditionsInterface $conditions = null)
    {
        $this->presets($conditions);
        
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
    }

    /**
     * @return bool
     */
    protected function hasAccess(): bool
    {
        return true;
    }

    /**
     * @return mixed
     * @throws ServiceException
     */
    protected function returnOnAccessDenied()
    {
        throw new ServiceException('Access denied!');
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
     * Execute service logic
     * @return mixed|void
     */
    abstract protected function execute();
}
