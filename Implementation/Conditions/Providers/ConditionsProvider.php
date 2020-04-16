<?php


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

        foreach ($providers as $pack) {
            $prepared[] = array_fill_keys($pack->getNames(), $pack);
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
            throw new \Exception();
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