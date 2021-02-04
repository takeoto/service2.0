<?php declare(strict_types=1);

namespace Implementation\Conditions\Providers;

use Core\ConditionInterface;
use Core\RuleInterface;

class RulesProvider implements RulesProviderInterface
{
    /**
     * @var RulesProviderInterface[]
     */
    private array $providers;

    /**
     * @var array
     */
    private array $names;

    /**
     * ConditionsProvider constructor.
     * @param RulesProviderInterface ...$providers
     */
    public function __construct(RulesProviderInterface ...$providers)
    {
        $prepared = [];

        foreach ($providers as $provider) {
            $prepared[] = array_fill_keys($provider->getNames(), $provider);
        }

        $this->providers = array_merge(...$prepared);
        $this->names = array_keys($this->providers);
    }

    /**
     * @inheritDoc
     */
    public function getRule(string $ruleName): RuleInterface
    {
        if (!isset($this->providers[$ruleName])) {
            throw new \Exception("Condition with \"$ruleName\" name not exists!");
        }

        return $this->providers[$ruleName]->getRule($ruleName);
    }

    /**
     * @inheritDoc
     */
    public function getNames(): array
    {
        return $this->names;
    }
}