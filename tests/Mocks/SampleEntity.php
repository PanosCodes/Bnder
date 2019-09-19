<?php

namespace Mocks;

use Doctrine\ORM\Mapping\Entity;

class SampleEntity
{
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
}