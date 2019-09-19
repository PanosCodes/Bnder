<?php

namespace Tests;

use Bender\Bender;
use Doctrine\ORM\Mapping\Entity;
use Mocks\SampleEntity;
use PHPUnit\Framework\TestCase;

class BenderTest extends TestCase
{
    public function testCreateFunction(): void
    {
        $properties = [
            'user' => new Entity(),
            'email' => 'hello@panos.codes'
        ];
        $sampleEntity = Bender::load(SampleEntity::class)->create($properties);

        $this->assertInstanceOf(Entity::class, $sampleEntity->getUser());
    }

    public function testCreateFunctionForMultiple(): void
    {
        $properties = [
            'user' => new Entity(),
            'email' => 'hello@panos.codes'
        ];
        $entities = Bender::load(SampleEntity::class)->create($properties, 10);

        $this->assertIsArray($entities);
        $this->assertCount(10, $entities);
    }
}
