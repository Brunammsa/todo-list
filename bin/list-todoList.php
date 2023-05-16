<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager->getRepository(Tasks::class);
$tasks = $taskRepository->findBy(['deletedAt' => null]);

echo "-- ID - TAREFA - CONCLUÍDO --" . PHP_EOL;

foreach ($tasks as $task) {
    echo $task->id . " - " . $task->name . " - ";

    if ($task->done == 0) {
        echo "NÃO" . PHP_EOL;
    } elseif ($task->done == 1) {
        echo "SIM" . PHP_EOL;
    }
}

echo PHP_EOL;
echo "Número total de tarefas: " . $taskRepository->count(['deletedAt' => null]) . PHP_EOL;
echo "Número de tarefas concluídas: " . $taskRepository->count(['done' => true, 'deletedAt' => null]) . PHP_EOL;

echo PHP_EOL;
