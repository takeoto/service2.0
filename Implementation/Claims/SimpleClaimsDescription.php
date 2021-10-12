<?php

namespace Implementation\Claims;

use Core\ConditionsInterface;
use Core\RuleInterface;

class SimpleClaimsDescription implements DescribableClaimsInterface
{
    private const DESCRIBE_IF = 'if';
    private const DESCRIBE_ELSE_IF = 'elseIf';
    private const DESCRIBE_ELSE = 'else';
    private const DESCRIBE_END_IF = 'endIf';
    private const DESCRIBE_CONDITION = 'condition';

    private $stack = [];
    private $pointers = [];

    public function if($condition): self
    {
        $this->putInStack(self::DESCRIBE_IF, ['condition' => $condition])->movePointerDown();

        return $this;
    }

    public function else(): self
    {
        $this->movePointerUp();
        $item = $this->lastInStack();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->putInStack(self::DESCRIBE_ELSE)->movePointerDown();

        return $this;
    }

    public function elseIf($condition): self
    {
        $this->movePointerUp();
        $item = $this->lastInStack();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->putInStack(self::DESCRIBE_ELSE_IF, ['condition' => $condition])->movePointerDown();

        return $this;
    }

    public function endIf(): self
    {
        $this->movePointerUp();
        $item = $this->lastInStack();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->putInStack(self::DESCRIBE_END_IF);

        return $this;
    }


    public function can(string $name, $rule = null): self
    {
        $this->putInStack(
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
        $this->putInStack(
            self::DESCRIBE_CONDITION,
            [
                'name' => $name,
                'req' => true,
                'rule' => $rule,
            ]
        );

        return $this;
    }

    public function claim(ConditionsInterface $conditions): ClaimedStatusInterface
    {
        $errors = [];
        $claims = $this->getClaims($this->stack, $conditions);

        /**
         * @var string $name
         * @var RuleInterface|null $rule
         * @var bool $required
         */
        foreach ($claims as ['name' => $name, 'rule' => $rule, 'req' => $required]) {
            if (!$conditions->has($name)) {
                $required && $errors[$name] = ['Is required!'];
                continue;
            }

            switch (true) {
                case $rule === null:
                    continue;
                case is_callable($rule):
                    break;
                case $rule instanceof RuleInterface:
                    
            }

            $status = $rule->verify($conditions->get($name));

            if ($status->isPassed()) {
                continue;
            }

            $errors[$name] = $status->getErrors();
        }
        
        return new SimpleClaimedStatus($errors); 
    }

    private function putInStack(string $type, array $data = []): self
    {
        array_push($this->stack(), [
            'type' => $type,
            'data' => $data,
        ]);

        return $this;
    }

    private function movePointerDown(): self
    {
        $_ = &$this->lastInStack();
        $_['stack'] = [];
        $this->pointers[] = &$_['stack'];

        return $this;
    }

    private function movePointerUp(): self
    {
        array_pop($this->pointers);

        return $this;
    }

    private function &stack(): array
    {
        $count = count($this->pointers);

        if ($count === 0) {
            return $this->stack;
        }

        return $this->pointers[$count - 1];
    }

    private function &lastInStack(): array
    {
        $_ = &$this->stack();
        $count = count($_);

        if ($count === 0) {
            return $_;
        }

        return $_[$count - 1];
    }

    private function getClaims(array $claims, $conditions): array
    {
        $result = [];
        
        while ($claim = current($claims)) {
            $type = $claim['type'];

            switch ($type) {
                case self::DESCRIBE_IF:
                case self::DESCRIBE_ELSE_IF:
                    $result = array_merge($result, $this->processIf($claim, $claims, $conditions));
                    break;
                case self::DESCRIBE_ELSE:
                    $this->getClaims($claim['stack'], $conditions);
                    break;
                case self::DESCRIBE_END_IF:
                    break;
                case self::DESCRIBE_CONDITION:
                    $result[$claim['name']] = $claim;
                    break;
                default:
                    throw new \Exception('');
            }
        }
        
        return $result;
    }

    private function nextTo(array &$claims, string $type): void
    {
        $claim = next($claims);
        
        if (!$claim || $claim['type'] === $type) {
            return;
        }
        
        $this->nextTo($claims, $type);
    }

    private function processIf(array $claim, array &$claims, $conditions): array
    {
        $condition = $claim['condition'];
        $result = [];
        
        switch (true) {
            case is_callable($condition):
                $accept = $condition($conditions) === true;
                break;
            case is_string($condition):
                
        }

        if ($condition($conditions) === true) {
            $result = $this->getClaims($claim['stack'] ?? [], $conditions);
            $this->nextTo($claims, self::DESCRIBE_END_IF);
        }
        
        return $result;
    }
}