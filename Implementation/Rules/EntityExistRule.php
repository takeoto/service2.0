<?php

namespace Implementation\Rules;

class EntityExistRule implements RuleInterface
{
    private $entityManager;

    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $errors = [];

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
        $this->errors = [];

        if (!$isPassed = $this->entityManager->find($this->className, $value)) {
            $this->errors[] = "Entity \"{$value}\" not exists!";
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
