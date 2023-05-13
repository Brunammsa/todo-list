<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager
    ->getRepository(Tasks::class)
    ->findBy([
        'deleted_at' => null
    ]);

#$tasksList = $taskRepository->todoTasks();

foreach ($taskRepository as $tasks) {
    echo $tasks->tasks . PHP_EOL;
}
