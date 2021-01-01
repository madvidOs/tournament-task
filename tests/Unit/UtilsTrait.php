<?php

namespace Tests\Unit;

/**
 *  Helpers for tests
 */
trait UtilsTrait
{
    /**
     * Call private method of a class using the Reflection class
     * 
     * @return mixed
     */
    public static function callPrivateMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
