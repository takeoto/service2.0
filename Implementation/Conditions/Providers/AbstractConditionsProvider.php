<?php declare(strict_types=1);

namespace Implementation\Conditions\Providers;

use Core\ConditionInterface;

abstract class AbstractConditionsProvider implements ConditionsProviderInterface
{
    /**
     * @var array[]
     */
    private static $cachedNames = [];

    protected $methodPrefix = 'make';

    /**
     * @inheritDoc
     */
    public function make(string $name, $value): ConditionInterface
    {
        if (!$this->hasCondition($name)) {
            throw new \Exception("Condition with \"$name\" name not exists!");
        }

        $method = $this->makeMethodName($name);

        if (!method_exists($this, $method)) {
            throw new \Exception("Can't create condition \"$name\"!");
        }

        $result = $this->$method();

        if (!is_subclass_of($result, ConditionInterface::class)) {
            throw new \Exception(
                sprintf(
                    'Method "%s" must return object instance of "%s"!',
                    $method,
                    ConditionInterface::class,
                )
            );
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getNames(): array
    {
        if (isset(self::$cachedNames[self::class])) {
            return self::$cachedNames[self::class];
        }

        $reflectionClass = new \ReflectionClass(static::class);
        self::$cachedNames[self::class] = array_filter(
            $reflectionClass->getConstants(),
            function ($name, $value) {
                return $this->isConditionNameConstant($name, $value);
            },
            ARRAY_FILTER_USE_BOTH
        );

        return self::$cachedNames[self::class];
    }

    /**
     * @param string $name
     * @return string
     */
    protected function makeMethodName(string $name): string
    {
        $pos = strrpos($name, '.');

        if ($pos) {
            $name = substr($name, $pos);
        }

        $name = str_replace(['-', '_'], ' ', $name);

        return $this->methodPrefix . str_replace(' ', '', ucwords($name));
    }

    /**
     * @param string $name
     * @param $value
     * @return bool
     */
    protected function isConditionNameConstant(string $name, $value): bool
    {
        return true;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function hasCondition(string $name): bool
    {
        return in_array($name, $this->getNames());
    }
}