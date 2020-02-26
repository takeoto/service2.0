<?php

class ZendValidatorAdapter implements RuleInterface
{
    /**
     * @var Zend_Validate_Interface
     */
    private $validator;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(Zend_Validate_Interface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        $this->errors = [];

        if (!$isPassed = $this->validator->isValid($value)) {
            $this->errors = $this->validator->getMessages();
        }

        return $isPassed;
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
