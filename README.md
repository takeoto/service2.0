# Service layer for PHP application (concept)
## Custom condition provider
```php
use Core\ConditionInterface;
use Implementation\Conditions\Providers\AbstractConditionsProvider;
use Implementation\Tools\ConditionsManager;
use Implementation\Tools\MakeRule;

class SomeConditionsProvider extends AbstractConditionsProvider
{
    // Some condition names
    public const FIRST_PARAM_NAME = 'some.first';
    public const SECOND_PARAM_NAME = 'some.second';
    public const THIRD_PARAM_NAME = 'some.third';
    public const FOURTH_PARAM_NAME = 'some.fourth';

    /**
     * @param $value
     * @return ConditionInterface
     */
    public function makeFirst($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::FIRST_PARAM_NAME,
            $value,
            MakeRule::int()
        );
    }

    /**
     * Make "second" condition for service
     * @param $value
     * @return ConditionInterface
     */
    public function makeSecond($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::SECOND_PARAM_NAME,
            $value,
            MakeRule::chain(
                MakeRule::int(),
                MakeRule::moreThen(10)
            )
        );
    }

    /**
     * Make "third" condition for service
     * @param $value
     * @return ConditionInterface
     */
    public function makeThird($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::THIRD_PARAM_NAME,
            $value,
            MakeRule::oneOf([
                'value1',
                'value2',
            ])
        );
    }

    /**
     * Make "fourth" condition for service
     * @param $value
     * @return ConditionInterface
     */
    public function makeFourth($value): ConditionInterface
    {
        return ConditionsManager::makeOne(
            self::FOURTH_PARAM_NAME,
            $value,
            MakeRule::int()
        );
    }
}
```
## Custom service
```php
use Implementation\Services\AbstractService;

class SomeService extends AbstractService
{
    /**
     * @inheritDoc
     */
    protected function execute()
    {
        // Not required condition
        if ($this->input()->has(SomeConditionsProvider::SECOND_PARAM_NAME)) {
            $secondValue = $this->input()->get(SomeConditionsProvider::SECOND_PARAM_NAME)->asInt();
            // Some logic ...
        }

        // Required condition (throw exception if the item not exists)
        $firstValue = $this->input()->get(SomeConditionsProvider::FIRST_PARAM_NAME)->asString();

        return 'pikachu';
    }
}
```

## Final usage

```php
### USAGE

use Implementation\Conditions\Providers\ConditionsProvider;

$service = new SomeService();
$manager = new ConditionsProvider(
    new SomeConditionsProvider(),
    # {multiple provider}
);

// Making conditions list
$conditions = ConditionsManager::makeList(
    $manager->make(SomeConditionsProvider::FIRST_PARAM_NAME, 123),
    $manager->make(SomeConditionsProvider::SECOND_PARAM_NAME, 123),
    $manager->make(SomeConditionsProvider::THIRD_PARAM_NAME, 'value123'),
);

/* Make conditions by array
$conditions = ConditionsManager::makeListByArray([
    SomeConditionsProvider::FIRST_PARAM_NAME => 123,
    SomeConditionsProvider::SECOND_PARAM_NAME => 123,
    SomeConditionsProvider::THIRD_PARAM_NAME => 'qwe123',
], $manager);
 */

$dynamicParams = [1, 2, 3, 4, 5, 6];

foreach ($dynamicParams as $newParam) {
    $conditions->replace($manager->make(SomeConditionsProvider::FOURTH_PARAM_NAME, $newParam));

    // Or check single condition `ConditionsManager::isCanBeUsed({newCondition})`
    if (!ConditionsManager::isListCorrect($conditions)) {
        $errors = ConditionsManager::getListErrors($conditions);
        // Some logic ...
        continue;
    }

    $result = $service->handle($conditions);;

    // Result data
    if ($result->asBool()) {
        /** @var {className} $object */
        $object = $result->asInstanceOf('{className}');
    }
}
```