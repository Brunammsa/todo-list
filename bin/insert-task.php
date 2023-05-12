<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\TodoList;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$task = new TodoList();
$task->addTask($argv[1]);

$entityManager->persist($task);
$entityManager->flush();