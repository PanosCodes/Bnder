<?php

namespace Tests;

use Bender\Bender;
use Bender\Factory;
use Doctrine\ORM\Mapping\Entity;
use Mocks\SampleEntity;
use PHPUnit\Framework\TestCase;

class BenderTest extends TestCase
{
    public function testCreateFunction(): void
    {
        $properties = [
            'user' => new Entity(),
            'email' => 'hello@bender.local',
        ];

        Bender::registerFactory(Factory::create(SampleEntity::class, $properties));

        // Exercise
        $sampleEntity = Bender::load(SampleEntity::class)->create();

        $this->assertInstanceOf(Entity::class, $sampleEntity->getUser());
    }

    public function testCreateFunctionForMultiple(): void
    {
        $properties = [
            'user' => new Entity(),
            'email' => 'hello@bender.local',
        ];

        Bender::registerFactory(Factory::create(SampleEntity::class, $properties));
        $entities = Bender::load(SampleEntity::class)->create(10);

        $this->assertIsArray($entities);
        $this->assertCount(10, $entities);
        $this->assertInstanceOf(SampleEntity::class, $entities[0]);
    }

    public function testRegisterFactoryMethod(): void
    {
        $factory = Factory::create(SampleEntity::class);
        $factories = Bender::registerFactory($factory);

        $this->assertCount(1, $factories);
    }
}
