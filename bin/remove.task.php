<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskId = readline("Agora digite o ID da tarefa que deseja excluir: ");

$taskRepository = $entityManager->getRepository(Tasks::class);
$task = $taskRepository->find($taskId);

if (!$task) {
    echo "Tarefa não encontrada" . PHP_EOL;
}

$confirmation = readline("tem certeza de que deseja excluir esta tarefa? ");

if (trim((strtolower($confirmation))) == 'sim') {
    $task->deletedAt = new DateTime();
    $entityManager->flush();
}