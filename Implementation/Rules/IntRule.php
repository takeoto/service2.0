<?php declare(strict_types=1);

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\StateInterface;
use Implementation\Rules\Results\TrueOrErrorState;

class IntRule implements RuleInterface
{
    public const PIKA_PARAM = 'pika';
    
    /**
     * @inheritDoc
     */
    public function verify($value): StateInterface
    {
        return new TrueOrErrorState(
            is_int($value),
            'Value must be integer!'
        );
    }
}
