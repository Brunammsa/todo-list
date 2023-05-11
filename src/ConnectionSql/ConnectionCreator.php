<?php

namespace Bruna\TodoList\ConnectionSql;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;

class ConnectionCreator
{
    public static function createEntityManager(): EntityManager
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env');

        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . "/.."],
            true
        );

        $connection = [
            'driver' => 'pdo_mysql',
            'host' => $_ENV["HOSTNAME"]
                . ';dbname='
                . $_ENV["DATABASE"],
            'user' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['PASSWORD'],
        ];

        return EntityManager::create($connection, $config);
    }
}
