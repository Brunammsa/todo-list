<?php

require_once __DIR__ . './../vendor/autoload.php';

use Brunammsa\Inputzvei\InputMenu;
use Brunammsa\Inputzvei\InputNumber;
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

    $task = new TodoList();

    $answer = readline("Digite a tarefa a ser adicionada: ");
    $deletedTask = null;
    $conclusiontask = 'NÃO';

    $task->addTask(new Tasks($answer, $deletedTask, $conclusiontask));

    $entityManager->persist($task);
    $entityManager->flush();

    echo "A tarefa '" . $answer . "' foi adicionada" . PHP_EOL . PHP_EOL;
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
        $taskRepository->deletedAt = 1;
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
}

function listTask(): void
{
    $entityManager = ConnectionCreator::createEntityManager();

    $taskRepository = $entityManager->getRepository(Tasks::class);
    $taskGetRepository = $entityManager
        ->getRepository(Tasks::class)
        ->findBy([
            'deletedAt' => null
        ]);

    echo "-- ID - TAREFA - CONCLUÍDO --" . PHP_EOL;

    foreach ($taskGetRepository as $tasks) {
        echo $tasks->id . " - " . $tasks->tasks . " - " . $tasks->doneTask . PHP_EOL;
    }

    echo PHP_EOL;
    echo "Número total de tarefas: " . $taskRepository->count([]) . PHP_EOL;
    echo "Número de tarefas concluídas: " . $taskRepository->count(['doneTask' => 'SIM']) . PHP_EOL;

    echo PHP_EOL;
}

main();
