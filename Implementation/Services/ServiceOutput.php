<?php

class ServiceOutput
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $errors;

    public function __construct($data, array $errors = [])
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
