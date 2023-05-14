<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager->getRepository(Tasks::class);

echo "Opções válidas:\n- TAREFA\n- CONCLUSÃO" . PHP_EOL;
$answerOption = readline("Digite a opção que gostaria de atualizar: ");
$answerId = readline("Agora digite o ID da tarefa desejada: ");

if (trim(strtoupper($answerOption)) == 'TAREFA') {
    $newTask = readline("Digite o novo conteúdo da tarefa aqui -> ");

    $task = $taskRepository->find($answerId);
    $task->tasks = $newTask;
} elseif (trim(strtoupper($answerOption)) == 'CONCLUSÃO') {
    $taskConclusion = readline("Se deseja marcar a tarefa como concluída, digite SIM, ou NÃO para manter em aberto: ");

    $task = $taskRepository->find($answerId);
    $task->doneTaks = $$taskConclusion;
}

$entityManager->persist($task);
$entityManager->flush();