<?php

use Implementation\Managers\ConditionsManager;
use Implementation\Services\OutputInterface;
use Implementation\Services\ResultInterface;
use Implementation\Services\InputInterface;
use Implementation\Services\StrictValueInterface;

class ServiceResult implements ResultInterface
{
    /**
     * @var InputInterface
     */
    private InputInterface $input;

    /**
     * @var OutputInterface
     */
    private OutputInterface $output;

    /**
     * ServiceResult constructor.
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->output->getErrors();
    }

    /**
     * @return StrictValueInterface
     */
    public function getData(): StrictValueInterface
    {
        return ConditionsManager::strictValue($this->output->getData());
    }
}
