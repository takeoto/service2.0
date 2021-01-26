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
    private const DESCRIBE_ELSE_IF = 'elseIf';
    private const DESCRIBE_ELSE = 'else';
    private const DESCRIBE_END_IF = 'endIf';
    private const DESCRIBE_CONDITION = 'condition';

    private $tree = [];
    private $pointers = [];

    public function if(callable $fn): self
    {
        $this->put(self::DESCRIBE_IF, ['fn' => $fn])->down();

        return $this;
    }

    public function else(): self
    {
        $this->up();
        $item = $this->lastInStack();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->put(self::DESCRIBE_ELSE)->down();

        return $this;
    }

    public function elseIf(callable $fn): self
    {
        $this->up();
        $item = $this->lastInStack();

        if (!in_array($item['type'] ?? null, [self::DESCRIBE_IF, self::DESCRIBE_ELSE_IF], true)) {
            throw new \Exception('');
        }

        $this->put(self::DESCRIBE_ELSE_IF, ['fn' => $fn])->down();

        return $this;
    }

    public function endIf(): self
    {
        $this->up();
        $item = $this->lastInStack();

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

    protected function claimed(ConditionsInterface $conditions): InputStateInterface
    {
        $errors = [];
        $names = [];
        $claims = $this->getClaims($this->tree, $conditions);

        /**
         * @var string $name
         * @var RuleInterface|null $rule
         * @var bool $required 
         */
        foreach ($claims as ['name' => $name, 'rule' => $rule, 'req' => $required]) {
            $names[$name] = $name;
            $has = $conditions->has($name);
            
            if ($required && !$has) {
                $errors[$name] = ['Is required!'];
                continue;
            }
            
            if (!$has) {
                continue;
            }
            
            $status = $rule->verify($conditions->get($name));
            
            if ($status->isPassed()) {
                continue;
            }

            $errors[$name] = $status->getErrors();
        }
        
        $conditions->each(function ($value, $name) use ($names) {
            
        });

        return new SimpleInputState($errors);
    }

    private function put(string $type, array $data = []): self
    {
        array_push($this->stack(), [
            'type' => $type,
            'data' => $data,
        ]);

        return $this;
    }

    private function down(): self
    {
        $_ = &$this->lastInStack();
        $_['stack'] = [];
        $this->pointers[] = &$_['stack'];

        return $this;
    }

    private function up(): self
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
        $fn = $claim['fn'];
        $result = [];

        if ($fn($conditions) === true) {
            $result = $this->getClaims($claim['stack'] ?? [], $conditions);
            $this->nextTo($claims, self::DESCRIBE_END_IF);
        }
        
        return $result;
    }
}