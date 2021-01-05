<?php

namespace Implementation\Services\Inputs\Drafts;

use Core\ConditionsInterface;
use Core\RuleInterface;
use Implementation\Services\DescribableInputInterface;
use Implementation\Services\Inputs\States\InputStateInterface;
use Implementation\Services\Inputs\States\SimpleInputState;

class SimpleInputDescription extends SimpleInputDraft implements DescribableInputInterface
{
    private const DESCRIBE_IF = 'if';
    private const DESCRIBE_IF_ELSE = 'ifElse';
    private const DESCRIBE_ELSE = 'else';
    private const DESCRIBE_END_IF = 'endIf';
    private const DESCRIBE_CONDITION = 'condition';
    
    private array $pointer; 
    private array $tree; 
    
    /**
     * @var array<string,RuleInterface>
     */
    private array $claims = [];
    private array $required = [];

    public function if(callable $fn): DescribableInputInterface
    {
        // TODO: Implement if() method.
    }

    public function else(): DescribableInputInterface
    {
        // TODO: Implement else() method.
    }

    public function elseIf(callable $fn): DescribableInputInterface
    {
        // TODO: Implement elseIf() method.
    }

    public function endIf(): DescribableInputInterface
    {
        // TODO: Implement endIf() method.
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

    protected function addClaim(string $type, array $data = []): void
    {
        
    }

    protected function claimed(?ConditionsInterface $conditions): InputStateInterface
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