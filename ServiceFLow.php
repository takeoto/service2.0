<?php
namespace Shit;
use Implementation\Planet\Context;
use Implementation\Planet\Flow;
use Implementation\Planet\Handler;

class ServiceFLow
{
    const CLAIMS = '1';
    const BEFORE_EXECUTE = '2';
    const EXECUTE = '3';
    const AFTER_EXECUTE = '4';
    const RESULT = 0;

    public function flow($input)
    {
        $portal = new \Implementation\Express();
        return $portal
            ->send($input)
            ->through([$this, 'claims'], self::CLAIMS)
            ->through([$this, 'claims'], self::CLAIMS)
            ->through([$this, 'beforeExecute'], self::BEFORE_EXECUTE)
            ->through([$this, 'execute'], self::EXECUTE)
            ->through([$this, 'afterExecute'], self::AFTER_EXECUTE)
            ->through([$this, 'result'], self::RESULT)
            ->through([
                self::CLAIMS => [$this, 'claims'],
                self::BEFORE_EXECUTE => [$this, 'beforeExecute'],
                self::EXECUTE => [$this, 'execute'],
                self::AFTER_EXECUTE => [$this, 'afterExecute'],
                self::RESULT => [$this, 'result'],
            ])
            ->thenReturn();
    }

    public function flow($input)
    {
        $portal = new Flow();
        return $portal
            ->send(new Context())
            
            
            ->through($this->execute(), self::CLAIMS)
            ->through(new Handler(), self::CLAIMS)
            ->through(new Handler(), self::BEFORE_EXECUTE)
            ->through(new Handler(), self::EXECUTE)
            ->through(new Handler(), self::AFTER_EXECUTE)
            ->through(new Handler(), self::RESULT)
            ->thenReturn();
    }
    
    
    
    

    protected function inputClaims(): \Implementation\Services\InputClaimsInterface
    {
        return new SimpleClaims();
    }

    protected function claimedConditions(\Core\ConditionsInterface $conditions)
    {

    }

    protected function buildInput(\Core\ConditionsInterface $conditions): \Implementation\Services\InputInterface
    {

    }

    protected function beforeExecute(\Implementation\Services\InputInterface $conditions): void
    {

    }

    protected function execute(\Implementation\Services\InputInterface $input)
    {
        return new Handler(function () {
        });
    }

    protected function afterExecute($result): void
    {

    }

    protected function onErrorResult(\Throwable $e)
    {

    }

    protected function result($executionResult)
    {

    }
}