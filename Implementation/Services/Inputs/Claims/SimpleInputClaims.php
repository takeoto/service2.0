<?php

namespace Implementation\Services\Inputs\Claims;

use Core\ConditionsInterface;
use Core\RuleInterface;
use Implementation\Services\Claims\SimpleInputState;
use Implementation\Services\InputClaimsInterface;
use Implementation\Services\InputInterface;
use Implementation\Services\Inputs\NullInput;
use Implementation\Services\Inputs\SimpleInput;
use Implementation\Services\InputStateInterface;

class SimpleInputClaims implements InputClaimsInterface
{
    /**
     * @var array<string,RuleInterface>
     */
    private array $claims = [];
    private array $required = [];

    public function claimed(?ConditionsInterface $conditions): InputInterface
    {
        return $conditions === null ? new NullInput() : new SimpleInput($conditions, $this->expose($conditions));
    }

    public function can(string $name, RuleInterface $rule = null): self
    {
        $this->addClaim($name, false, $rule);
        
        return $this;
    }

    public function must(string $name, RuleInterface $rule = null): self
    {
        $this->addClaim($name, true, $rule);
        
        return $this;
    }

    protected function addClaim(string $name, bool $required, RuleInterface $rule = null): void
    {
        $this->claims[$name] = $rule;
        
        if ($required) {
            $this->required[$name] = $name;
        }
    }

    public function expose(?ConditionsInterface $conditions): InputStateInterface
    {
        $errors = [];
        $required = $this->required;
        $claims = $this->claims;

        if ($conditions !== null) {
            $conditions->each(function ($value, $name) use ($required, $claims, $errors) {
                unset($required[$name]);

                if (!isset($claims[$name])) {
                    return;
                }

                $status = $claims[$name]->verify($value);

                if ($status->isPassed()) {
                    return;
                }

                $errors[$name] = $status->getErrors();
            });
        }
        
        return new SimpleInputState($errors + array_fill_keys($required, 'Is required!'));
    }
}