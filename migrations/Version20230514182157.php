<?php

declare(strict_types=1);

namespace Bruna\TodoList\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514182157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Tasks (id INT AUTO_INCREMENT NOT NULL, tasks VARCHAR(255) NOT NULL, deteledAt VARCHAR(255) DEFAULT NULL, doneTask VARCHAR(255) NOT NULL, todoList_id INT DEFAULT NULL, INDEX IDX_91994A9362AB5DB6 (todoList_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TodoList (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Tasks ADD CONSTRAINT FK_91994A9362AB5DB6 FOREIGN KEY (todoList_id) REFERENCES TodoList (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Tasks DROP FOREIGN KEY FK_91994A9362AB5DB6');
        $this->addSql('DROP TABLE Tasks');
        $this->addSql('DROP TABLE TodoList');
    }
}
