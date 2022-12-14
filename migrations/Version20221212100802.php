<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212100802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, users_id_id INT NOT NULL, about_me LONGTEXT DEFAULT NULL, avatar LONGBLOB DEFAULT NULL, UNIQUE INDEX UNIQ_7D3656A498333A1E (users_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, start_date DATE NOT NULL, center VARCHAR(40) NOT NULL, formation VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A498333A1E FOREIGN KEY (users_id_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9D0C07AFF ON users (promo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9D0C07AFF');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A498333A1E');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP INDEX IDX_1483A5E9D0C07AFF ON users');
        $this->addSql('ALTER TABLE users DROP promo_id');
    }
}
