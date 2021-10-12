<?php


namespace Implementation\Rules\Providers;

use Implementation\Tools\MakeRule;

class RulesProvider extends AbstractRulesProvider
{
    public const RULE_NAME = 'pikachu_id';

    public function makePikachuId()
    {
        return MakeRule::int(); 
    }
}