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
    $deletedTask = null;
    $conclusiontask = 'NÃO';

    $task->addTask(new Tasks($answer, $deletedTask, $conclusiontask));

    $entityManager->persist($task);
    $entityManager->flush();
}

function removeTask(): void
{
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
}

function updateTask(): void
{
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
}

function listTask(): void
{
    $entityManager = ConnectionCreator::createEntityManager();

    $taskRepository = $entityManager->getRepository(Tasks::class);
    $taskRepository = $entityManager
        ->getRepository(Tasks::class)
        ->findBy([
            'deleted_at' => null
        ]);

    echo "------------- ID       -       TAREFA -       CONCLUÍDO -------------" . PHP_EOL;

    foreach ($taskRepository as $tasks) {
        echo $tasks->id . " - " . $tasks->tasks . " - " . $tasks->doneTask . PHP_EOL;
    }
}

main();
