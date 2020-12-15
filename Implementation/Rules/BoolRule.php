<?php declare(strict_types=1);

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\StateInterface;
use Implementation\Rules\Results\TrueOrErrorState;

class BoolRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function verify($value): StateInterface
    {
        return new TrueOrErrorState(
            is_bool($value),
            'Value must be boolean!'
        );
    }
}
