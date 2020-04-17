<?php

namespace Implementation\Rules;

class OneOfRule implements RuleInterface
{
    /**
     * @var array
     */
    private $values;
    /**
     * @var bool
     */
    private $strict;

    public function __construct(array $values, bool $strict = false)
    {
        $this->values = $values;
        $this->strict = $strict;
    }

    /**
     * @inheritDoc
     */
    public function pass($value): RuleResultInterface
    {
        return new TrueOrErrorRuleResult(
            in_array(
                $value,
                $this->values,
                $this->strict
            ),
            'Value must be one of items: ' . implode(',', $this->values)
        );
    }
}
