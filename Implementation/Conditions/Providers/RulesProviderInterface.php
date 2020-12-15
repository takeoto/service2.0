<?php declare(strict_types=1);

namespace Implementation\Conditions\Providers;

use Core\RuleInterface;

interface RulesProviderInterface
{
    /**
     * @param string $fieldName
     * @return RuleInterface
     */
    public function make(string $fieldName): RuleInterface;

    /**
     * @return array
     */
    public function getNames(): array;
}