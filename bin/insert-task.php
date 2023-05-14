<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;
use Bruna\TodoList\Entities\TodoList;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$task = new TodoList();

$answer = readline("Digite a tarefa a ser adicionada: ");
$deletedTask = null;
$conclusiontask = 'NÃO';
$task->addTask(new Tasks($answer, $deletedTask, $conclusiontask));
$entityManager->persist($task);
$entityManager->flush();