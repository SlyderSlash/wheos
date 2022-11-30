<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130101505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9667303880');
        $this->addSql('DROP INDEX IDX_DB021E9667303880 ON messages');
        $this->addSql('ALTER TABLE messages CHANGE file_id file_id INT DEFAULT NULL, CHANGE forum_id_id forum_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9629CCBAD0 FOREIGN KEY (forum_id) REFERENCES forums (id)');
        $this->addSql('CREATE INDEX IDX_DB021E9629CCBAD0 ON messages (forum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9629CCBAD0');
        $this->addSql('DROP INDEX IDX_DB021E9629CCBAD0 ON messages');
        $this->addSql('ALTER TABLE messages CHANGE file_id file_id INT NOT NULL, CHANGE forum_id forum_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9667303880 FOREIGN KEY (forum_id_id) REFERENCES forums (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DB021E9667303880 ON messages (forum_id_id)');
    }
}
