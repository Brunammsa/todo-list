<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$answer = readline("Digite a tarefa a ser adicionada: ");
$deletedTask = null;

$task = new Tasks($answer, $deletedTask, false);

$entityManager->persist($task);
$entityManager->flush();

echo "A tarefa '" . $answer . "' foi adicionada" . PHP_EOL . PHP_EOL;