<?php declare(strict_types=1);

namespace Implementation\Conditions\Providers;

use Core\RuleInterface;

abstract class AbstractRulesProvider implements RulesProviderInterface
{
    /**
     * @var array[]
     */
    private static $cachedNames = [];

    protected $methodPrefix = 'make';

    /**
     * @inheritDoc
     */
    public function getRule(string $ruleName): RuleInterface
    {
        if (!$this->hasRule($ruleName)) {
            throw new \Exception("Condition with \"$ruleName\" name not exists!");
        }

        $method = $this->makeMethodName($ruleName);

        if (!method_exists($this, $method)) {
            throw new \Exception("Can't create condition \"$ruleName\"!");
        }

        $result = $this->$method($ruleName);

        if (!is_subclass_of($result, RuleInterface::class)) {
            throw new \Exception(
                sprintf(
                    'Method "%s" must return object instance of "%s"!',
                    $method,
                    RuleInterface::class,
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
        if (isset(self::$cachedNames[static::class])) {
            return self::$cachedNames[static::class];
        }

        $reflectionClass = new \ReflectionClass(static::class);
        self::$cachedNames[static::class] = array_filter(
            $reflectionClass->getConstants(),
            function ($name, $value) {
                return $this->isConditionNameConstant($name, $value);
            },
            ARRAY_FILTER_USE_BOTH
        );

        return self::$cachedNames[static::class];
    }

    /**
     * @param string $ruleName
     * @return string
     */
    protected function makeMethodName(string $ruleName): string
    {
        $pos = strrpos($ruleName, '.');

        if ($pos) {
            $ruleName = substr($ruleName, $pos);
        }

        $ruleName = str_replace(['-', '_'], ' ', $ruleName);

        return $this->methodPrefix . str_replace(' ', '', ucwords($ruleName));
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
    protected function hasRule(string $name): bool
    {
        return in_array($name, $this->getNames(), true);
    }
}