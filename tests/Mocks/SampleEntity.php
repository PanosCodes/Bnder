<?php

namespace Mocks;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="sample_entity")
 */
class SampleEntity
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @var Entity
     */
    protected $user;

    /**
     * @return Entity
     */
    public function getUser(): Entity
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return SampleEntity
     */
    public function setName(string $name): SampleEntity
    {
        $this->name = $name;

        return $this;
    }
}