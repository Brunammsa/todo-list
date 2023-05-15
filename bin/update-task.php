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
    main();
}

if ($answer == 1) {
    $newTask = readline("Digite o novo conteúdo da tarefa aqui -> ");
    $task->name = $newTask;

    echo "Tarefa de ID  ". $answerId . " foi alterada para '" . $newTask . "'" . PHP_EOL;
} elseif ($answer == 2) {
    $task->done = true;
    echo "Tarefa marcada como concluída" . PHP_EOL;
}

$entityManager->persist($task);
$entityManager->flush();