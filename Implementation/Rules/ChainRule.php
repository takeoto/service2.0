<?php declare(strict_types=1);

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\RuleStateInterface;
use Implementation\Rules\Results\SimpleRuleState;

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
    public function pass($value): RuleStateInterface
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

        return new SimpleRuleState((bool)$isPassed, $errors);
    }
}
