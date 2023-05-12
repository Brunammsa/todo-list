<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;

require_once __DIR__ . './../vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();

