<?php

namespace Bruna\TodoList\Repository;

use Doctrine\ORM\EntityRepository;

class TasksRepository extends EntityRepository
{
    public function todoTasks(): array
    {
        return $this->createQueryBuilder('todoList')
        ->addSelect('tasks')
        ->leftJoin('todoList.tasks', 'tasks')
        ->getQuery()
        ->getResult();
    }
}