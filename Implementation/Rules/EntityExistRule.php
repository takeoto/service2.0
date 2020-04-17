<?php

namespace Implementation\Rules;

use Core\RuleInterface;

class EntityExistRule implements RuleInterface
{
    private $entityManager;

    /**
     * @var
     */
    private $value;

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
