<?php declare(strict_types=1);

namespace Implementation\Conditions\Providers;

use Core\ConditionInterface;

class ConditionsProvider implements ConditionsProviderInterface
{
    /**
     * @var ConditionsProviderInterface[]
     */
    private array $providers;

    /**
     * @var array
     */
    private array $names;

    /**
     * ConditionsProvider constructor.
     * @param ConditionsProviderInterface ...$providers
     */
    public function __construct(ConditionsProviderInterface ...$providers)
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
    public function make(string $name, $value): ConditionInterface
    {
        if (!isset($this->providers[$name])) {
            throw new \Exception("Condition with \"$name\" name not exists!");
        }

        return $this->providers[$name]->make($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function getNames(): array
    {
        return $this->names;
    }
}