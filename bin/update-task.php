<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;
use Brunammsa\Inputzvei\InputMenu;
use Brunammsa\Inputzvei\InputNumber;



require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager->getRepository(Tasks::class);

$inputOption = new InputMenu('Digite o número da opção desejada:');
$inputOption->addOption('1', 'Tarefa')->addOption('2', 'Conclusão');
$option = $inputOption->askOption();

$inputId = new InputNumber('Digite o ID da tarefa desejada:');
$answerId = $inputId->ask();

$task = $taskRepository->find(intval($answerId));

if (is_null($task)) {
    echo "ID inexistente" . PHP_EOL;
    return;
}

if ($option == 'Tarefa') {
    $newTask = readline("Digite o novo conteúdo da tarefa aqui -> ");
    $task->name = $newTask;

    echo "Tarefa de ID  " . $answerId . " foi alterada para '" . $newTask . "'" . PHP_EOL;
} elseif ($option == 'Conclusão') {
    $task->done = !$task->done;
    echo "Tarefa alterada" . PHP_EOL;
}

$entityManager->persist($task);
$entityManager->flush();