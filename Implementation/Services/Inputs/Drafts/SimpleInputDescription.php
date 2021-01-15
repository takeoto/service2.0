<?php

namespace Implementation\Services\Inputs\Drafts;

use Core\ConditionsInterface;
use Implementation\Services\DescribableInputInterface;
use Implementation\Services\Inputs\States\InputStateInterface;
use Implementation\Services\Inputs\States\SimpleInputState;

class SimpleInputDescription extends SimpleInputDraft implements DescribableInputInterface
{
    private const DESCRIBE_IF = 'if';
    private const DESCRIBE_ELSE_IF = 'elseIf';
    private const DESCRIBE_ELSE = 'else';
    private const DESCRIBE_END_IF = 'endIf';
    private const DESCRIBE_CONDITION = 'condition';

    private $tree = [];
    private $pointers = [];

    public function if(callable $fn): self
    {
        $this->put(self::DESCRIBE_IF, ['fn' => $fn]);
        $this->deep();

        return $this;
    }

    public function else(): self
    {
        $this->shallow();
        $item = $this->current();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->put(self::DESCRIBE_ELSE)->deep();

        return $this;
    }

    public function elseIf(callable $fn): self
    {
        $this->shallow();
        $item = $this->current();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->put(self::DESCRIBE_ELSE_IF, ['fn' => $fn])->deep();

        return $this;
    }

    public function endIf(): self
    {
        $this->shallow();
        $item = $this->current();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->put(self::DESCRIBE_END_IF);

        return $this;
    }


    public function can(string $name, $rule = null): self
    {
        $this->put(
            self::DESCRIBE_CONDITION,
            [
                'name' => $name,
                'req' => false,
                'rule' => $rule,
            ]
        );

        return $this;
    }

    public function must(string $name, $rule = null): self
    {
        $this->put(
            self::DESCRIBE_CONDITION,
            [
                'name' => $name,
                'req' => true,
                'rule' => $rule,
            ]
        );

        return $this;
    }

    private function put(string $type, array $data = []): self
    {
        array_push($this->stack(), [
            'type' => $type,
            'data' => $data,
        ]);

        return $this;
    }

    private function deep(): self
    {
        $_ = &$this->current();
        $_['stack'] = [];
        $this->pointers[] = &$_['stack'];

        return $this;
    }

    private function shallow(): self
    {
        array_pop($this->pointers);

        return $this;
    }

    private function &stack(): array
    {
        $count = count($this->pointers);

        if ($count === 0) {
            return $this->tree;
        }

        return $this->pointers[$count - 1];
    }

    private function &current(): array
    {
        $_ = &$this->stack();
        $count = count($_);

        if ($count === 0) {
            return $_;
        }

        return $_[$count - 1];
    }

    protected function claimed(?ConditionsInterface $conditions): InputStateInterface
    {
        $errors = [];
        $required = $this->required;
        $claims = $this->prepareClaims($this->tree, $conditions);

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

    private function prepareClaims(array $claims, $conditions): array
    {
        $result = [];
        
        foreach ($claims as $claim) {
            $type = $claim['type'];
            
            switch ($type) {
                case self::DESCRIBE_IF:
                    $fn = $claim['fn'];
                    
                    if ($fn($conditions) === true) {
                        $this->prepareClaims($claim['stack'], $conditions);
                    }
                    break;
            }
            
        }
    }
}