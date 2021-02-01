<?php

namespace Implementation\Claims;

use Core\RuleInterface;

interface DescribableClaimsInterface extends ClaimsInterface
{
    public function can(string $name, RuleInterface $rule = null): self;
    public function must(string $name, RuleInterface $rule = null): self;
    public function if($condition): self;
    public function else(): self;
    public function elseIf($condition): self;
    public function endIf(): self;
}