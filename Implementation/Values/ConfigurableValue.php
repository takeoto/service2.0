<?php

namespace Implementation\Values;

class ConfigurableValue implements StrictValueInterface
{
    public const OPTION_OVERWRITE = 'overwrite';

    public const OPTION_INT_CASTER = 'int';
    public const OPTION_FLOAT_CASTER = 'float';
    public const OPTION_BOOL_CASTER = 'bool';
    public const OPTION_STRING_CASTER = 'string';
    public const OPTION_ARRAY_CASTER = 'array';
    public const OPTION_INSTANCEOF_CASTER = 'instanceOf';

    private array $options;
    private bool $isOverwriteMode;
    private $value;

    public function __construct($value, array $options)
    {
        $this->options = $options;
        $this->value = $value;
        $this->preset();
    }

    public function asInt(): int
    {
        return $this->castValue($this->value, self::OPTION_INT_CASTER, fn($value) => (int)$value);
    }

    /**
     * @return bool
     */
    public function asBool(): bool
    {
        return $this->castValue($this->value, self::OPTION_BOOL_CASTER, fn($value) => (bool)$value);
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->castValue($this->value, self::OPTION_STRING_CASTER, fn($value) => (string)$value);
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return $this->castValue($this->value, self::OPTION_ARRAY_CASTER, fn($value) => (array)$value);
    }

    public function asFloat(?int $precision = null): float
    {
        return $this->castValue(
            $this->value,
            self::OPTION_FLOAT_CASTER,
            fn($value) => (float)number_format((float)$value, $precision, '.', '')
        );
    }

    public function asInstanceOf(string $name): object
    {
        return $this->castValue(
            $this->value,
            self::OPTION_INSTANCEOF_CASTER,
            function ($value) use ($name) {
                if (!$value instanceof $name) {
                    throw new \Exception('');
                }

                return $value;
            }
        );
    }

    /**
     * @return mixed
     */
    public function original()
    {
        return $this->value;
    }

    private function preset()
    {
        $this->isOverwriteMode = isset($this->options[self::OPTION_OVERWRITE])
            ? (bool)$this->options[self::OPTION_OVERWRITE]
            : false;
    }

    private function getCaster(string $name): ?callable
    {
        if (!isset($this->options[$name])) {
            return null;
        }

        $converter = $this->options[$name];

        if (!is_callable($converter)) {
            throw new \Exception('');
        }

        return $converter;
    }

    protected function ensureOverwrite(): void
    {
        if ($this->isOverwriteMode) {
            return;
        }

        throw new \Exception('');
    }

    /**
     * @param $value
     * @param string $castName
     * @param callable $default
     * @return mixed
     * @throws \Exception
     */
    protected function castValue($value, string $castName, callable $default)
    {
        $converter = $this->getCaster($castName);

        if ($converter === null) {
            $this->ensureOverwrite();
        } else {
            return $converter($value);
        }

        return $default($value);
    }
}