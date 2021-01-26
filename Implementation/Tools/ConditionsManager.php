<?php declare(strict_types=1);

namespace Implementation\Tools;

use Core\ConditionsInterface;
use Implementation\Conditions\SimpleConditions;

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
