<?php

namespace Implementation\Rules\Providers;

use Core\RuleInterface;
use Implementation\Providers\AbstractProvider;

abstract class AbstractRulesProvider extends AbstractProvider
{
    public function make(string $name, ...$params): RuleInterface
    {
        $condition = parent::make($name, $params);

        if (!is_subclass_of($condition, RuleInterface::class)) {
            throw new \Exception(
                sprintf(
                    'Provider must return object instance of "%s"!',
                    RuleInterface::class,
                )
            );
        }
        
        return $condition;
    }

    protected function isNameConstant(string $name, $value): bool
    {
        return strpos('RULE', $name) === 0;
    }

    protected function ensureParamsValid(string $ruleName, array $params): void
    {
        $method = $this->makeParamsValidatorMethodName($ruleName);
        
        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    protected function makeParamsValidatorMethodName(string $ruleName): string
    {
        return 'ensure' . $ruleName . 'ParamsValid';
    }
}