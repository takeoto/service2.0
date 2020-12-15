<?php declare(strict_types=1);

namespace Implementation\Rules;

use Core\RuleInterface;
use Core\StateInterface;
use Implementation\Rules\Results\TrueOrErrorState;

class MoreThenRule implements RuleInterface
{
    /**
     * @var float
     */
    private $moreThen;


    public function __construct(float $moreThen)
    {
        $this->moreThen = $moreThen;
    }

    /**
     * @inheritDoc
     */
    public function verify($value): StateInterface
    {
        return new TrueOrErrorState(
            $this->moreThen < $value,
            "Value \"$value\" must be more then \"$this->moreThen\"!"
        );
    }
}
