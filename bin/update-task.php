<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;
use Brunammsa\Inputzvei\InputNumber;


require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager->getRepository(Tasks::class);

echo "Opções válidas:\n- 1 -> TAREFA\n- 2 -> CONCLUSÃO" . PHP_EOL;
$inputNumb = new InputNumber("Digite o número da opção desejada: ");
$answer = $inputNumb->ask();

$answerId = readline("Agora digite o ID da tarefa desejada: ");
$task = $taskRepository->find($answerId);

if (is_null($task)) {
    echo "ID inexistente" . PHP_EOL;
    exit;
}

if ($answer == 1) {
    $newTask = readline("Digite o novo conteúdo da tarefa aqui -> ");

    $task->tasks = $newTask;
} elseif ($answer == 2) {
    $taskConclusion = readline("Se deseja marcar a tarefa como concluída, digite SIM, ou NÃO para manter em aberto: ");

    $task->doneTask = strtoupper($taskConclusion);

}

$entityManager->persist($task);
$entityManager->flush();

