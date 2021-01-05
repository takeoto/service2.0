<?php

namespace Implementation\Services;

use Core\ConditionsInterface;
use Implementation\Services\Exceptions\ServiceException;
use Implementation\Services\Inputs\Drafts\SimpleInputDescription;
use Implementation\Services\Inputs\InputInterface;

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
    /**
     * @var SimpleInputDescription|null
     */
    private ?SimpleInputDescription $inputDraft;

    /**
     * @param ConditionsInterface|null $conditions
     * @return StrictValueInterface
     * @throws \Throwable
     */
    public function handle(?ConditionsInterface $conditions = null): StrictValueInterface
    {
        return parent::handle($conditions);
    }

    /**
     * @inheritdoc
     */
    protected function presets(?ConditionsInterface $conditions): void
    {
        if ($conditions !== null) {
            $conditions = $conditions->filter(fn() => true, true);
        }

        $this->setInput($this->inputDraft()->expose($conditions));
    }

    /**
     * @inheritdoc
     */
    protected function hasAccess(): bool
    {
        return $this->getInput()->getState()->isCanBeUsed();
    }

    /**
     * @inheritdoc
     */
    protected function returnOnAccessDenied()
    {
        throw new ServiceException(
            'Service input errors: ' .
            implode(',', $this->getInput()->getState()->whyItsCantBeUsed())
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
        return new StrictValue(parent::return($type, $data));
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

    abstract protected function inputDraft(): InputDraftInterface;
}