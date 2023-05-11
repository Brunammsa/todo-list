<?php

require 'vendor/autoload.php';

use Bruna\TodoList\ConnectionSql\ConnectionCreator;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;

$config = new PhpFile(__DIR__ . '/migrations.php');

$entityManager = ConnectionCreator::createEntityManager();

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));