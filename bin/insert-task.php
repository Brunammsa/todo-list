<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;
use Bruna\TodoList\Entities\TodoList;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$task = new TodoList();
$task->addTask(new Tasks($argv[1]));

$entityManager->persist($task);
$entityManager->flush();