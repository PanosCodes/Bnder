<?php

namespace Bender;

use ReflectionClass;

class Bender
{
    /**
     * @param       $entity
     * @param array $properties
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public static function create($entity, $properties = [])
    {
        $instance = new $entity;

        if (count($properties) > 0) {
           return $instance;
        }

        $reflection = new ReflectionClass($instance);

        foreach ($properties as $propertyName => $propertyValue) {
            if (property_exists($instance, $propertyName)) {
                $reflection->getProperty($propertyName)->setValue($propertyValue);
            }
        }

        return $instance;
    }
}