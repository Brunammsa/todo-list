<?php

namespace Bruna\TodoList\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Tasks
{
    #[Id, GeneratedValue, Column]
    public int $id;

    #[ManyToOne(targetEntity: TodoList::class, inversedBy: 'tasks')]
    public readonly string $todoList;

    public function __construct(
        #[Column]
        public string $tasks
    ) {
    }

    public function setTodoList(TodoList $todoList): void
    {
        $this->todoList = $todoList;
    }
}
