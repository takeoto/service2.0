<?php

namespace Implementation\Rules;

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
        return new SimpleRuleResult(
            $this->validator->isValid($value),
            $this->validator->getMessages()
        );
    }
}
