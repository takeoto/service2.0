<?php declare(strict_types=1);

namespace Implementation\Providers;

use Core\RuleInterface;

abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var array[]
     */
    private static $names = [];

    protected $methodPrefix = 'make';

    /**
     * @inheritDoc
     */
    public function make(string $name, ...$params)
    {
        $this->ensureNameValid($name);
        $this->ensureParamsValid($name, $params);

        $method = $this->makeMethodName($name);

        if (!method_exists($this, $method)) {
            throw new \Exception("Can't create condition \"$name\"!");
        }
        
        return $this->$method(...$params);
    }

    /**
     * @inheritDoc
     */
    public function getNames(): array
    {
        if (isset(self::$names[static::class])) {
            return self::$names[static::class];
        }

        $reflectionClass = new \ReflectionClass(static::class);
        self::$names[static::class] = array_filter(
            $reflectionClass->getConstants(),
            function ($name, $value) {
                return $this->isNameConstant($name, $value);
            },
            ARRAY_FILTER_USE_BOTH
        );

        return self::$names[static::class];
    }

    protected function makeMethodName(string $ruleName): string
    {
        $pos = strrpos($ruleName, '.');

        if ($pos) {
            $ruleName = substr($ruleName, $pos);
        }

        $ruleName = str_replace(['-', '_'], ' ', $ruleName);

        return $this->methodPrefix . str_replace(' ', '', ucwords($ruleName));
    }

    protected function isNameConstant(string $name, $value): bool
    {
        return true;
    }

    public function has(string $name): bool
    {
        return in_array($name, $this->getNames(), true);
    }

    protected function ensureParamsValid(string $ruleName, array $params): void
    {
    }

    protected function ensureNameValid(string $name): void
    {
    }
}