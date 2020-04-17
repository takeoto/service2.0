<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleResultInterface;
use Implementation\Rules\Results\TrueOrErrorRuleResult;

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
    public function pass($value): RuleResultInterface
    {
        return new TrueOrErrorRuleResult(
            !is_null($this->entityManager->find($this->className, $value)),
            "Entity \"$value\" not exists!"
        );
    }
}
