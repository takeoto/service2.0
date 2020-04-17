<?php

namespace Implementation\Conditions;

use Core\ConditionInterface;
use Core\RuleInterface;
use Core\RuleResultInterface;

class SimpleCondition implements ConditionInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var RuleInterface|null
     */
    private $rule;

    /**
     * @var RuleResultInterface|null
     */
    private $ruleResult;

    /**
     * SimpleCondition constructor.
     * @param string $name
     * @param $value
     * @param RuleInterface$rule
     */
    public function __construct(string $name, $value, RuleInterface $rule)
    {
        $this->name = $name;
        $this->value = $value;
        $this->rule = $rule;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function followRule(): RuleResultInterface
    {
        return $this->ruleResult ?: $this->ruleResult = $this->rule->pass($this->getValue());
    }
}
