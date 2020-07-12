<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleStateInterface;
use Implementation\Rules\Results\TrueOrErrorRuleState;

class EntityExistRule implements RuleInterface
{
    private $entityManager;

    /**
     * @var string
     */
    private $className;

    public function __construct($entityManager, string $className)
    {
        $this->entityManager = $entityManager;
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function pass($value): RuleStateInterface
    {
        return new TrueOrErrorRuleState(
            !is_null($this->entityManager->find($this->className, $value)),
            "Entity \"$value\" not exists!"
        );
    }
}
