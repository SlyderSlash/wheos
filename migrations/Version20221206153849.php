<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221206153849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3AF34668727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_messages (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, forum_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_FCF19371A76ED395 (user_id), INDEX IDX_FCF1937129CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forums (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, is_resolved TINYINT(1) NOT NULL, is_closed TINYINT(1) NOT NULL, INDEX IDX_FE5E5AB8A76ED395 (user_id), INDEX IDX_FE5E5AB812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE forum_messages ADD CONSTRAINT FK_FCF19371A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE forum_messages ADD CONSTRAINT FK_FCF1937129CCBAD0 FOREIGN KEY (forum_id) REFERENCES forums (id)');
        $this->addSql('ALTER TABLE forums ADD CONSTRAINT FK_FE5E5AB8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE forums ADD CONSTRAINT FK_FE5E5AB812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE forum_messages DROP FOREIGN KEY FK_FCF19371A76ED395');
        $this->addSql('ALTER TABLE forum_messages DROP FOREIGN KEY FK_FCF1937129CCBAD0');
        $this->addSql('ALTER TABLE forums DROP FOREIGN KEY FK_FE5E5AB8A76ED395');
        $this->addSql('ALTER TABLE forums DROP FOREIGN KEY FK_FE5E5AB812469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE forum_messages');
        $this->addSql('DROP TABLE forums');
    }
}
