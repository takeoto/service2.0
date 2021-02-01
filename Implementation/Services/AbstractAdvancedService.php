<?php

namespace Implementation\Services;

use Core\ConditionsInterface;
use Implementation\Claims\ClaimsInterface;
use Implementation\Claims\DescribableClaimsInterface;
use Implementation\Claims\SimpleClaimsDescription;
use Implementation\Services\Exceptions\ServiceException;
use Implementation\Services\Inputs\InputInterface;
use Implementation\Services\Inputs\SimpleInput;
use Implementation\Tools\ConditionsManager;

/**
 * Class AbstractAdvancedService
 * @package Implementation\Services
 */
abstract class AbstractAdvancedService extends AbstractService
{
    /**
     * @var InputInterface
     */
    private InputInterface $input;
    
    private ?ClaimsInterface $inputClaims;

    /**
     * @param ConditionsInterface|null $conditions
     * @return StrictValueInterface
     * @throws \Throwable
     */
    public function handle(?ConditionsInterface $conditions = null): StrictValueInterface
    {
        return parent::handle($conditions);
    }

    public function getClaims(): ClaimsInterface
    {
        return $this->inputClaims ?: $this->inputClaims = $this->inputClaims();
    }

    /**
     * @inheritdoc
     */
    protected function presets(?ConditionsInterface $conditions): void
    {
        if ($conditions === null) {
            $conditions = ConditionsManager::makeList();
        }

        $this->setInput(new SimpleInput($conditions, $this->getClaims()));
    }

    /**
     * @inheritdoc
     */
    protected function hasAccess(): bool
    {
        return $this->getInput()->getState()->isCorrect();
    }

    /**
     * @inheritdoc
     */
    protected function returnOnAccessDenied()
    {
        throw new ServiceException(
            'Service input errors: ' .
            implode(',', $this->getInput()->getState()->whyItsNotCorrect())
        );
    }

    /**
     * @param string $type
     * @param mixed $data
     * @return StrictValueInterface
     * @throws \Throwable
     */
    protected function return(string $type, $data = null): StrictValueInterface
    {
        $value = parent::return($type, $data);
        
        if ($value instanceof StrictValueInterface) {
            return $value;
        }
        
        return new StrictValue($value);
    }

    /**
     * @param InputInterface $input
     */
    protected function setInput(InputInterface $input): void
    {
        $this->input = $input;
    }

    /**
     * @return InputInterface
     */
    protected function getInput(): InputInterface
    {
        return $this->input;
    }

    abstract protected function inputClaims(): ClaimsInterface;
}