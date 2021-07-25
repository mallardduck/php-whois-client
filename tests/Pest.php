<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

use MallardDuck\Whois\Test\PrivatePropertyReader;

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

function getMethod($class, $name)
{
    $class = new \ReflectionClass($class);
    $method = $class->getMethod($name);
    $method->setAccessible(true);
    return $method;
}

/**
 * Returns the magical private property reader closure.
 *
 * The magic here is that we return a static closure that takes an object and property name.
 * This static closure will then bind an internal (non-static) closure to the object passed.
 * This second internal closure simply return the value of passesd property name on '$this'.
 * The context of '$this' being defined by the object that the closure is being bound to.
 *
 * @return PrivatePropertyReader|Closure
 */
function getReader(): Closure
{
    /**
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    return static function & ($object, $property) {
        $value = & \Closure::bind(function & () use ($property) {
            return $this->$property;
        }, $object, $object)->__invoke();

        return $value;
    };
}
