<?php

class ServiceConditions
{
    /**
     * @var ConditionsInterface
     */
    private $conditions;

    public function __construct(ConditionsInterface $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return $this->has($name);
    }

    /**
     * @param string $name
     * @return FormlessValue
     */
    public function getValue(string $name): FormlessValue
    {
        return ConditionsManager::formlessValue($this->conditions->find($name)->getValue());
    }
}
