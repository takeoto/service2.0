<?php

namespace Implementation\Services;

interface ClaimsStateInterface
{
    public function isCorrect(): bool;
    public function getErrors(): array;
}