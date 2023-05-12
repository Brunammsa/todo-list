<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Bruna\TodoList\Entities\Tasks;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

$taskRepository = $entityManager->getRepository(Tasks::class);

$task = $taskRepository->find($argv[1]);
$task->tasks = $argv[2];


$entityManager->persist($task);
$entityManager->flush();