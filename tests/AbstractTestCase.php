<?php

namespace Coxy121\RingCentralLaravel\Tests;

use Orchestra\Testbench\TestCase;
use Coxy121\RingCentralLaravel\RingCentralServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            RingCentralServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'RingCentral' => \RingCentralServiceProvider\Laravel\Facade\RingCentral::class,
        ];
    }

    /**
     * Gets the property of an object of a class.
     *
     * @param string $class
     * @param string $property
     * @param mixed $object
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function getClassProperty($class, $property, $object)
    {
        $reflectionClass = new \ReflectionClass($class);
        $refProperty = $reflectionClass->getProperty($property);
        $refProperty->setAccessible(true);

        return $refProperty->getValue($object);
    }

}
