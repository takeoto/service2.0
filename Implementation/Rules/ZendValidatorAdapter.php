<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleStateInterface;
use Implementation\Rules\Results\SimpleRuleState;

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
    public function pass($value): RuleStateInterface
    {
        return new SimpleRuleState(
            $this->validator->isValid($value),
            $this->validator->getMessages()
        );
    }
}
