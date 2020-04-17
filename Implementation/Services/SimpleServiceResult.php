<?php

use Core\ConditionsInterface;
use Implementation\Managers\ConditionsManager;
use Implementation\Services\ResultInterface;
use Implementation\Services\ServiceInput;
use Implementation\Services\ServiceOutput;
use Implementation\Services\StrictValue;

class SimpleServiceResult implements ResultInterface
{
    /**
     * @var ServiceInput
     */
    private ServiceInput $input;

    /**
     * @var ServiceOutput
     */
    private ServiceOutput $output;

    /**
     * ServiceResult constructor.
     * @param ServiceInput $input
     * @param ServiceOutput $output
     */
    public function __construct(ServiceInput $input, ServiceOutput $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function getConditions(): ConditionsInterface
    {
        return $this->input->conditions();
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->output->getErrors();
    }

    /**
     * @return StrictValue
     */
    public function getData(): StrictValue
    {
        return ConditionsManager::strictValue($this->output->getData());
    }
}
