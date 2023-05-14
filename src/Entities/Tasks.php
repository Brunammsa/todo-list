<?php

namespace Bruna\TodoList\Entities;

use Bruna\TodoList\Repository\TasksRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(TasksRepository::class)]
class Tasks
{
    #[Id, GeneratedValue, Column]
    public int $id;

    #[ManyToOne(targetEntity: TodoList::class, inversedBy: 'tasks')]
    public readonly TodoList $todoList;

    public function __construct(
        #[Column(nullable:false)]
        public string $tasks,

        #[Column(nullable:true)]
        private $deteledAt,

        #[Column]
        public string $doneTask
    ) {
    }

    public function setTodoList(TodoList $todoList): void
    {
        $this->todoList = $todoList;
    }
}
