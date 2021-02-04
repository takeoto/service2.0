<?php declare(strict_types=1);

namespace Implementation\Conditions\Providers;

use Core\RuleInterface;

interface RulesProviderInterface
{
    /**
     * @param string $ruleName
     * @return RuleInterface
     */
    public function getRule(string $ruleName): RuleInterface;

    /**
     * @return array
     */
    public function getNames(): array;
}