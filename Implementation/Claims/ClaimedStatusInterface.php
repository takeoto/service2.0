<?php
namespace Implementation\Claims;

interface ClaimedStatusInterface
{
    public const STATUS_CORRECT = 'correct';
    public const STATUS_INCORRECT = 'incorrect';
    public const STATUS_MISSING = 'missing';
    public const STATUS_EXCESSIVE = 'excessive';

    public function getStatus(string $name = null): string;

    public function getCorrect(): array;
    public function getIncorrect(): array;
    public function getExcessive(): array;
    public function getMissing(): array;
}