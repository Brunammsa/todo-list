<?php

use Bruna\TodoList\ConnectionSql\ConnectionCreator;

require_once 'vendor/autoload.php';

$entityManager = ConnectionCreator::createEntityManager();
var_dump($entityManager);