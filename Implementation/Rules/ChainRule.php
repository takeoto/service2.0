<?php

class ChainRule implements RuleInterface
{
    /**
     * @var RuleInterface
     */
    private $rules;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        /** @var RuleInterface $rule */
        foreach ($this->rules as $rule) {
            $ruleResult = $rule->pass($value);

            if ($ruleResult->isPassed()) {
                continue;
            }

            array_push($this->errors, ...$ruleResult->getErrors());
            break;
        }

        return new SimpleRuleResult($this->errors);
    }
}
