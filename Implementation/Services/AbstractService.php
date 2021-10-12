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
        $this->flushEvent('beforeHandle');
        $this->presets($conditions);
        $permission = $this->getHandleAccess();
        
        if ($this->accessIsGiven($permission)) {
            $this->flushEvent('onAccessDenied');
            return $this->return(self::RETURN_TYPE_ACCESS_DENIED, $permission);
        }

        $this->flushEvent('beforeExec');

        try {
            $execResult = $this->execute();
            $this->flushEvent('afterExec', $execResult);
        } catch (\Throwable $e) {
            $this->flushEvent('error', $e);
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
     * @param mixed $permission
     * @return bool
     */
    protected function accessIsGiven($permission): bool
    {
        return $permission === true;
    }

    /**
     * @return mixed
     */
    protected function getHandleAccess()
    {
        return true;
    }

    /**
     * @param mixed $data
     * @return mixed
     * @throws ServiceException
     */
    protected function returnOnAccessDenied($data)
    {
        throw new ServiceException('Access denied!');
    }

    protected function flushEvent(string $name, ...$payload)
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
                $result = $this->returnOnAccessDenied($data);
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
