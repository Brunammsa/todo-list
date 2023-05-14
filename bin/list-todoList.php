<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager
    ->getRepository(Tasks::class)
    ->findBy([
        'deletedAt' => null
    ]);

echo "-- ID - TAREFA - CONCLUÍDO --" . PHP_EOL;

foreach ($taskRepository as $tasks) {
    echo $tasks->id . " - " . $tasks->tasks . " - " . $tasks->doneTask . PHP_EOL;
}
