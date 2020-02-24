<?php

class SimpleServiceResult implements ServiceResultInterface
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var array
     */
    private $errors;
    /**
     * @var ConditionsInterface
     */
    private $conditions;

    public function __construct(ConditionsInterface $conditions, array $data, array $errors = [])
    {
        $this->data = $data;
        $this->errors = $errors;
        $this->conditions = $conditions;
    }

    /**
     * {@inheritDoc}
     */
    public function getConditions(): ConditionsInterface
    {
        return $this->conditions;
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return $this->data;
    }
}
