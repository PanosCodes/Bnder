<?php

namespace Tests;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Mocks\SampleEntity;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * Test groups
     */
    public const TEST_GROUP_DATABASE = 'Database';

    /**
     * @var EntityManager | null
     */
    protected $entityManager = null;

    public function setUp(): void
    {
        if (in_array(self::TEST_GROUP_DATABASE, $this->getGroups(), true)) {
            $connectionParams = ['url' => 'sqlite:///:memory:'];
            $connection = DriverManager::getConnection($connectionParams);
            $entityManager = EntityManager::create(
                $connection,
                Setup::createAnnotationMetadataConfiguration(['../Mocks/'])
            );
            $this->entityManager = $entityManager;
            $this->entityManager->beginTransaction();
            $this->createTables();
        }
    }

    public function tearDown(): void
    {
        if (in_array(self::TEST_GROUP_DATABASE, $this->getGroups(), true)) {
            $this->dropTables();
            $this->entityManager->rollback();
        }
    }

    private function createTables(): void
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema([$this->entityManager->getClassMetadata(SampleEntity::class)]);
    }

    private function dropTables(): void
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->dropSchema([$this->entityManager->getClassMetadata(SampleEntity::class)]);
    }
}