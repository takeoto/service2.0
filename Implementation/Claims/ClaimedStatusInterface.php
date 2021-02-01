<?php
namespace Implementation\Claims;

interface ClaimedStatusInterface
{
    public function isCorrect(string $name = null): bool;
    public function whyItsNotCorrect(string $name = null): array;
}