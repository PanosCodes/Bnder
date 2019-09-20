<?php

namespace Bender;

use Exception;
use ReflectionClass;
use RuntimeException;

class Bender
{
    /**
     * Exception Message
     */
    private const EXCEPTION_MESSAGE_CAN_NOT_CREATE_ZERO_INSTANCES = 'Can not create zero instances';
    private const EXCEPTION_MESSAGE_FACTORY_IS_NOT_REGISTERED = 'Factory is not registered.';

    /**
     * @var Factory[]
     */
    private static $factories = [];

    /**
     * @var string
     */
    protected $class;

    /**
     * @param string $class
     */
    private function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @param string $class
     *
     * @return Bender
     * @throws Exception
     */
    public static function load(string $class): Bender
    {
        if (array_key_exists($class, self::$factories)) {
            return new self($class);
        }

        throw new RuntimeException(self::EXCEPTION_MESSAGE_FACTORY_IS_NOT_REGISTERED);
    }

    /**
     * @param Factory $factory
     *
     * @return array
     */
    public static function registerFactory(Factory $factory): array
    {
        self::$factories[$factory->getClass()] = $factory;

        return self::$factories;
    }

    /**
     * @param int $numberOfInstances
     *
     * @return array | mixed
     * @throws Exception
     */
    public function create(int $numberOfInstances = 1)
    {
        if ($numberOfInstances === 0) {
            throw new RuntimeException(self::EXCEPTION_MESSAGE_CAN_NOT_CREATE_ZERO_INSTANCES);
        }

        $instances = [];

        for ($i = 0; $i < $numberOfInstances; $i++) {
            $instance = $this->createInstance(self::$factories[$this->class]);
            $instances[] = $instance;
        }

        if (count($instances) === 1) {
            return $instances[0];
        }

        return $instances;
    }

    /** @noinspection PhpDocMissingThrowsInspection
     *
     * @param Factory $factory
     *
     * @return mixed
     */
    private function createInstance(Factory $factory)
    {
        $instance = new $this->class;

        if (count($factory->getProperties()) === 0) {
            return $instance;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new ReflectionClass($instance);

        foreach ($factory->getProperties() as $propertyName => $propertyValue) {
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
