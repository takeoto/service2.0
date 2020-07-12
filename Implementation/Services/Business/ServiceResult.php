<?php
namespace Implementation\Services\Business;

use Implementation\Managers\ConditionsManager;

class ServiceResult implements ResultInterface
{
    private array $data;
    private array $errors;

    /**
     * ServiceResult constructor.
     * @param array $data
     * @param array $errors
     */
    public function __construct(array $data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return StrictValueInterface
     */
    public function getData(): StrictValueInterface
    {
        return ConditionsManager::strictValue($this->data);
    }
}
