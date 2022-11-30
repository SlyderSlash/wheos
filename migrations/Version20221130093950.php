<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130093950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forums (id INT AUTO_INCREMENT NOT NULL, categories_id INT NOT NULL, title VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, is_resolved TINYINT(1) NOT NULL, is_closed TINYINT(1) NOT NULL, user_id INT NOT NULL, INDEX IDX_FE5E5AB8A21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forums ADD CONSTRAINT FK_FE5E5AB8A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forums DROP FOREIGN KEY FK_FE5E5AB8A21214B7');
        $this->addSql('DROP TABLE forums');
    }
}
