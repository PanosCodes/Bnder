<?php

namespace Bender;

use Exception;
use ReflectionClass;

class Bender
{
    const EXCEPTION_MESSAGE_CAN_NOT_CREATE_ZERO_INSTANCES = 'Can not create zero instances';
    /**
     * @var string
     */
    protected $factory;

    /**
     * @param string $factory
     */
    public function __construct(string $factory)
    {
       $this->factory = $factory;
    }

    /**
     * @param string $factory
     *
     * @return Bender
     */
    public static function load(string $factory): Bender
    {
        return new self($factory);
    }

    /**
     * @param int   $numberOfInstances
     * @param array $properties
     *
     * @return array | mixed
     * @throws Exception
     */
    public function create($properties = [], $numberOfInstances = 1)
    {
        if ($numberOfInstances === 0) {
            throw new \RuntimeException(self::EXCEPTION_MESSAGE_CAN_NOT_CREATE_ZERO_INSTANCES);
        }

        $instances = [];

        for ($i = 0; $i < $numberOfInstances; $i++) {
            $instance = $this->createInstance($properties);
            $instances[] = $instance;
        }

        if (count($instances) === 1) {
            return reset($instances);
        }

        return $instances;
    }


    /** @noinspection PhpDocMissingThrowsInspection
     *
     * @param array $properties
     *
     * @return mixed
     */
    private function createInstance(array $properties)
    {
        $instance = new $this->factory;

        if (count($properties) === 0) {
            return $instance;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new ReflectionClass($instance);

        foreach ($properties as $propertyName => $propertyValue) {
            if ($reflection->hasProperty($propertyName)) {
                /** @noinspection PhpUnhandledExceptionInspection */
                $property = $reflection->getProperty($propertyName);
                $property->setAccessible(true);
                $property->setValue($instance, $propertyValue);
            }
        }

        return $instance;
    }
}