<?php


namespace Implementation\Services\Claims;


use Core\ConditionsInterface;
use Core\RuleInterface;
use Implementation\Services\DescribableInputInterface;
use Implementation\Services\Inputs\Claims\SimpleInputDraft;
use Implementation\Services\InputStateInterface;

class SimpleInputDescription extends SimpleInputDraft implements DescribableInputInterface
{
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

    protected function addClaim(string $name, bool $required, RuleInterface $rule = null): void
    {
        $this->claims[$name] = $rule;

        if ($required) {
            $this->required[$name] = $name;
        }
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