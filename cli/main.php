<?php

require_once __DIR__ . './../vendor/autoload.php';

use Brunammsa\Inputzvei\InputMenu;
use Brunammsa\Inputzvei\InputNumber;
use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

function main(): void
{
    echo "------------- TO DO LIST -------------" . PHP_EOL;
    menu();
}

function menu(): void
{
    $isValid = true;

    while ($isValid) {
        echo "Opções válidas\n- Insert\n- Remove\n- Update\n- List \n- 0 para finalizar" . PHP_EOL;

        $inputOptions = new InputMenu('Digite a opção desejada: ');
        $answer = ucfirst($inputOptions->ask());

        if (trim($answer) == 'Insert') {
            insertTask();
        } elseif (trim($answer) == 'Remove') {
            removeTask();
        } elseif (trim($answer) == 'Update') {
            updateTask();
        } elseif (trim($answer) == 'List') {
            listTask();
        } elseif ($answer == 0) {
            exit();
        }
    }
}


function insertTask(): void
{
    $entityManager = ConnectionCreator::createEntityManager();

    $answer = readline("Digite a tarefa a ser adicionada: ");
    $deletedTask = null;

    $task = new Tasks($answer, $deletedTask, false);

    $entityManager->persist($task);
    $entityManager->flush();

    echo "A tarefa '" . $answer . "' foi adicionada" . PHP_EOL . PHP_EOL;
}

function removeTask(): void
{
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
}

function updateTask(): void
{
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

        echo "Tarefa de ID  " . $answerId . " foi alterada para '" . $newTask . "'" . PHP_EOL;
    } elseif ($answer == 2) {
        $task->done = true;
        echo "Tarefa marcada como concluída" . PHP_EOL;
    }

    $entityManager->persist($task);
    $entityManager->flush();
}

function listTask(): void
{
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
    echo "Número total de tarefas: " . $taskRepository->count(['deletedAt' => null] ) . PHP_EOL;
    echo "Número de tarefas concluídas: " . $taskRepository->count(['done' => true, 'deletedAt' => null]) . PHP_EOL;

    echo PHP_EOL;
}

main();
