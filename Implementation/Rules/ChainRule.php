<?php

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleResultInterface;
use Implementation\Rules\Results\SimpleRuleResult;

class ChainRule implements RuleInterface
{
    /**
     * @var RuleInterface
     */
    private $rules;

    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        $isPassed = true;
        $errors = [];

        /** @var RuleInterface $rule */
        foreach ($this->rules as $rule) {
            $ruleResult = $rule->pass($value);

            if ($isPassed &= $ruleResult->isPassed()) {
                continue;
            }

            array_push($errors, ...$ruleResult->getErrors());
            break;
        }

        return new SimpleRuleResult((bool)$isPassed, $errors);
    }
}
