<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205145919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD forums_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668618BA34B FOREIGN KEY (forums_id) REFERENCES forums (id)');
        $this->addSql('CREATE INDEX IDX_3AF34668618BA34B ON categories (forums_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668618BA34B');
        $this->addSql('DROP INDEX IDX_3AF34668618BA34B ON categories');
        $this->addSql('ALTER TABLE categories DROP forums_id');
    }
}
