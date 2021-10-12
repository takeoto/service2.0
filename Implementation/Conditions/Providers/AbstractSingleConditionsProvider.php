<?php


namespace Implementation\Conditions\Providers;

use Implementation\Conditions\LazyCondition;
use Implementation\Rules\Providers\AbstractRulesProvider;

abstract class AbstractSingleConditionsProvider extends AbstractConditionsProvider
{
    public const CONDITION_NAME = 'PIKACHU';
    
    protected AbstractRulesProvider $rulesProvider;

    public function __construct(AbstractRulesProvider $rulesProvider)
    {
        $this->rulesProvider = $rulesProvider;
    }

    public function makeCondition(string $name, $value)
    {
        return new LazyCondition($name, $value, $this->rulesProvider->make($name));
    }
    
    protected function makeMethodName(string $ruleName): string
    {
        return 'makeCondition';
    }

    protected function ensureParamsValid(string $ruleName, array $params): void
    {
        switch (false) {
            case count($params) === 2: 
            case is_string(reset($params)):
                throw new \Exception('Wrong params!');
        }
    }
}