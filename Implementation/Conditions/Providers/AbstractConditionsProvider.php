<?php

namespace Implementation\Conditions\Providers;

use Core\ConditionInterface;

abstract class AbstractConditionsProvider implements ConditionsProviderInterface
{
    /**
     * @var array[]
     */
    private static $cachedNames = [];

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
            function ($name) {
                return $this->endsWith($name, '_NAME');
            },
            ARRAY_FILTER_USE_KEY
        );

        return self::$cachedNames[self::class];
    }

    /**
     * @param string $name
     * @return string
     */
    private function makeMethodName(string $name): string
    {
        $pos = strrpos($name, '.');

        if ($pos) {
            $name = substr($name, $pos);
        }

        return 'make' . ucfirst($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    private function hasCondition(string $name): bool
    {
        return in_array($name, $this->getNames());
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    private function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }
}