<?php


namespace Implementation\Conditions\Providers;


use Core\ConditionsInterface;
use Implementation\Providers\AbstractProvider;

abstract class AbstractConditionsProvider extends AbstractProvider
{
    public function make(string $name, ...$params): ConditionsInterface
    {
        $condition = parent::make($name, $params);

        if (!is_subclass_of($condition, ConditionsInterface::class)) {
            throw new \Exception(
                sprintf(
                    'Provider must return object instance of "%s"!',
                    ConditionsInterface::class,
                )
            );
        }
        
        return $condition;
    }

    protected function isNameConstant(string $name, $value): bool
    {
        return strpos('CONDITION', $name) === 0;
    }
}