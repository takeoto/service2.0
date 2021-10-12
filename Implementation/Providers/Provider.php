<?php declare(strict_types=1);

namespace Implementation\Providers;

use Core\ConditionInterface;
use Core\RuleInterface;

class Provider implements ProviderInterface
{
    /**
     * @var ProviderInterface[]
     */
    private array $providers;

    /**
     * @var array
     */
    private array $names;

    /**
     * ConditionsProvider constructor.
     * @param ProviderInterface ...$providers
     */
    public function __construct(ProviderInterface ...$providers)
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
    public function make(string $name, ...$params)
    {
        if (!isset($this->providers[$name])) {
            throw new \Exception("Condition with \"$name\" name not exists!");
        }

        return $this->providers[$name]->make($name, ...$params);
    }

    /**
     * @inheritDoc
     */
    public function getNames(): array
    {
        return $this->names;
    }
}