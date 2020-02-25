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
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        $this->validator->isValid($value);

        return new SimpleRuleResult($this->validator->getMessages());
    }
}
