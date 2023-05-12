<?php

require_once __DIR__ . './../vendor/autoload.php';

use Brunammsa\Inputzvei\InputMenu;
use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;
use Bruna\TodoList\Entities\TodoList;

function main(): void
{
    echo "------------- TO DO LIST -------------" . PHP_EOL;
    menu();
}

function menu(): void
{
    $isValid = true;

    while ($isValid) {
        echo "Opções válidas\n- Insert\n- Remove\n- Update\n- List \n- 0 " . PHP_EOL;

        $inputOptions = new InputMenu('Agora digite a opção desejada: ');
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

    $task = new TodoList();
    $answer = readline("Digite a tarefa a ser adicionada: ");
    $task->addTask(new Tasks($answer));

    $entityManager->persist($task);
    $entityManager->flush();
}

function removeTask(): void
{
}

function updateTask(): void
{
    $entityManager = ConnectionCreator::createEntityManager();

    $taskRepository = $entityManager->getRepository(Tasks::class);

    $answerId = readline("Qual o ID da tarefa a ser atualizada ");
    $task = $taskRepository->find($answerId);

    $answerAtt = readline("Digite a tarefa atualizada");
    $task->tasks = $answerAtt;

    $entityManager->persist($task);
    $entityManager->flush();
}

function listTask(): void
{
    $entityManager = ConnectionCreator::createEntityManager();

    $taskRepository = $entityManager->getRepository(Tasks::class);
    $taskList = $taskRepository->findAll();

    foreach ($taskList as $task) {
        echo $task->tasks . PHP_EOL;
    }

    echo "Número total de tarefas: " . $taskRepository->count([]) . PHP_EOL;
}

main();
