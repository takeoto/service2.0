<?php

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
        $errors = [];

        !$this->entityManager->find($this->className, $value) && $errors[] = "Entity \"{$this->value}\" not exists!";

        return new SimpleRuleResult($errors);
    }
}
