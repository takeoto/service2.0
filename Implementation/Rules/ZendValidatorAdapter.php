<?php

class ZendValidatorAdapter implements RuleInterface
{
    /**
     * @var Zend_Validate_Interface
     */
    private $validator;

    public function __construct(Zend_Validate_Interface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        return $this->validator->isValid($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->validator->getMessages();
    }
}
