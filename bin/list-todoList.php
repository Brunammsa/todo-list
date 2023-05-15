<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager->getRepository(Tasks::class);
$tasks = $entityManager
    ->getRepository(Tasks::class)
    ->findBy([
        'deletedAt' => null
    ]);

echo "-- ID - TAREFA - CONCLUÍDO --" . PHP_EOL;

foreach ($tasks as $tasks) {
    echo $tasks->id . " - " . $tasks->name . " - ";
    
    if ($tasks->done == 0) {
        echo "NÃO" . PHP_EOL;
    } elseif ($tasks->done == 1) {
        echo "SIM" . PHP_EOL;
    }
}

echo PHP_EOL;
echo "Número total de tarefas: " . $taskRepository->count([]) . PHP_EOL;
echo "Número de tarefas concluídas: " . $taskRepository->count(['done' => true]) . PHP_EOL;

echo PHP_EOL;
