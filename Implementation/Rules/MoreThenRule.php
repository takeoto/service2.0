<?php declare(strict_types=1);

namespace Implementation\Rules;

use Core\ExtendableInterface;
use Core\RuleInterface;
use Core\RuleStateInterface;
use Implementation\Rules\Results\TrueOrErrorRuleState;

class MoreThenRule implements RuleInterface, ExtendableInterface
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
    public function verify($value): RuleStateInterface
    {
        return new TrueOrErrorRuleState(
            $this->moreThen < $value,
            "Value \"$value\" must be more then \"$this->moreThen\"!"
        );
    }

    public function extend(ExtendableInterface $extendable)
    {
        $this->moreThen = $extendable->getOptions()['moreThen'];
    }

    public function getOptions(): array
    {
        return [
            'moreThen' => $this->moreThen,
        ];
    }
}
