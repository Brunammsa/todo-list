<?php

namespace Bruna\TodoList\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class TodoList
{
    #[Id, GeneratedValue, Column]
    public int $id;

    #[OneToMany(targetEntity: Tasks::class, mappedBy: 'todoList', cascade: ['persist', 'remove'])]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function tasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Tasks $task): void
    {

        if ($this->tasks->contains($task)) {
            return;
        }
        $this->tasks->add($task);
        $task->setTodoList($this);
    }
}
