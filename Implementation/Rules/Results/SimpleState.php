<?php declare(strict_types=1);

namespace Implementation\Rules\Results;

use Core\StateInterface;

class SimpleState implements StateInterface
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var bool
     */
    private $isPassed;

    public function __construct(bool $passed, array $errors)
    {
        $this->isPassed = $passed;
        $this->errors = $errors;
    }
    
    /**
     * @inheritDoc
     */
    public function isCorrect(): bool
    {
        return $this->isPassed;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
