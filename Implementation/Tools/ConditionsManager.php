<?php declare(strict_types=1);

namespace Implementation\Tools;

use Core\ConditionInterface;
use Core\ConditionsInterface;
use Core\RuleInterface;
use Implementation\Conditions\Providers\RulesProviderInterface;
use Implementation\Conditions\SimpleCondition;
use Implementation\Conditions\SimpleConditions;
use Implementation\Services\StrictValue;

class ConditionsManager
{
    /**
     * @param array<string,mixed>[] $conditions
     * @return ConditionsInterface
     */
    public static function makeList(array $conditions = []): ConditionsInterface
    {
        return new SimpleConditions($conditions);
    }
}
