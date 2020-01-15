<?php

namespace Bnder;

class Factory
{
    /**
     * @var
     */
    private $class;

    /**
     * @var array
     */
    private $properties;

    /**
     * Factory constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string $class
     * @param array  $properties
     *
     * @return Factory
     */
    public static function create(string $class, array $properties = []): Factory
    {
        $factory = new self();
        $factory->class = $class;
        $factory->properties = $properties;

        return $factory;
    }
}