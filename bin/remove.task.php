<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;
use Brunammsa\Inputzvei\InputMenu;
use Brunammsa\Inputzvei\InputNumber;


require_once __DIR__ . './../vendor/autoload.php';

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