<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$answer = readline("Para excluir uma tarefa, digite SIM: ");

$taskId = readline("Agora digite o ID da tarefa que deseja excluir: ");

$taskRepository = $entityManager->getRepository(Tasks::class)->find($taskId);

if (!$taskRepository) {
    echo "Tarefa não encontrada" . PHP_EOL;
}

$confirmation = readline("tem certeza de que deseja excluir esta tarefa? ");

if (trim((strtolower($confirmation))) == 'sim') {
    $taskRepository->doneTask = 'SIM';
}