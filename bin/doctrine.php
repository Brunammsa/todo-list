<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();


ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
