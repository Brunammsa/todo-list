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
        $input = new InputMenu('Digite a numeração referente a opção desejada:');
        $input->addOption('1', 'Insert')->addOption('2', 'Remove')->addOption('3', 'Update')->addOption('4', 'List')->addOption('0', 'Encerrar');
        $option = $input->askOption();

        if ($option == 'Insert') {
            insertTask();
        } elseif ($option == 'Remove') {
            removeTask();
        } elseif ($option == 'Update') {
            updateTask();
        } elseif ($option == 'List') {
            listTask();
        } elseif ($option == 'Encerrar') {
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

    $inputId = new InputNumber('Digite o ID da tarefa desejada:');
    $answerId = $inputId->ask();

    $taskRepository = $entityManager->getRepository(Tasks::class);
    $task = $taskRepository->find(intval($answerId));
        
    if (!$task) {
        echo "Tarefa não encontrada" . PHP_EOL;
        return;
    }
    
    $input = new InputMenu("Se tem certeza de que deseja excluir a tarefa, digite a numeração referente a opção:");
    $input->addOption('1', 'Sim')->addOption('2','Cancelar');
    $option = $input->askOption();
    
    if ($option == 'Sim') {
        $task->deletedAt = new DateTime();
        $entityManager->flush();
    
        echo 'Tarefa removida' . PHP_EOL;
    } elseif ($option == 'Cancelar') {
        echo 'Operação remove cancelada' . PHP_EOL;
        return;
    }
}

function updateTask(): void
{
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
    echo "Número total de tarefas: " . $taskRepository->count(['deletedAt' => null]) . PHP_EOL;
    echo "Número de tarefas concluídas: " . $taskRepository->count(['done' => true, 'deletedAt' => null]) . PHP_EOL;

    echo PHP_EOL;
}

main();
