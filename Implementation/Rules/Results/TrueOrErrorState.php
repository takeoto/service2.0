<?php declare(strict_types=1);

namespace Implementation\Rules\Results;

use Core\StateInterface;

class TrueOrErrorState implements StateInterface
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var bool
     */
    private $isPassed;

    public function __construct(bool $passed, string $message)
    {
        if (!$this->isPassed = $passed) {
            $this->errors[] = $message;
        }
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
