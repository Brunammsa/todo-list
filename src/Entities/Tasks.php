<?php

namespace Bruna\TodoList\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use DateTime;

#[Entity]
class Tasks
{
    #[Id, GeneratedValue, Column]
    public int $id;

    public function __construct(
        #[Column(nullable: false)]
        public string $name,

        #[Column(nullable: true)]
        public ?DateTime $deletedAt,

        #[Column(nullable: false)]
        public bool $done
    ) {
    }
}
