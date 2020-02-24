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
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        return (bool)$this->entityManager->find($this->className, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return ["Entity \"{$this->value}\" not exists!"];
    }
}
