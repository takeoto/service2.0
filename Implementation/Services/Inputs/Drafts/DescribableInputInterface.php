<?php

namespace Implementation\Services;

use Core\RuleInterface;

interface DescribableInputInterface extends InputDraftInterface
{
    public function can(string $name, RuleInterface $rule = null): self;
    public function must(string $name, RuleInterface $rule = null): self;
    public function if(callable $fn): self;
    public function else(): self;
    public function elseIf(callable $fn): self;
    public function endIf(): self;
}