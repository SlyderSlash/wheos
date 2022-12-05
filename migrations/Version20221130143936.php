<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130143936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendars (id INT AUTO_INCREMENT NOT NULL, time_limit INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', finish_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', categorie VARCHAR(150) NOT NULL, task VARCHAR(150) NOT NULL, remote TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chats (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_read TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, name LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', path LONGTEXT NOT NULL, INDEX IDX_63540599D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_chats (files_id INT NOT NULL, chats_id INT NOT NULL, INDEX IDX_175A81C4A3E65B2F (files_id), INDEX IDX_175A81C4AC6FF313 (chats_id), PRIMARY KEY(files_id, chats_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_calendars (files_id INT NOT NULL, calendars_id INT NOT NULL, INDEX IDX_FC2DE5B4A3E65B2F (files_id), INDEX IDX_FC2DE5B472C4B705 (calendars_id), PRIMARY KEY(files_id, calendars_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_messages (files_id INT NOT NULL, messages_id INT NOT NULL, INDEX IDX_2EAC07DEA3E65B2F (files_id), INDEX IDX_2EAC07DEA5905F5A (messages_id), PRIMARY KEY(files_id, messages_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files_categories_files (files_categories_id INT NOT NULL, files_id INT NOT NULL, INDEX IDX_A9CAFAE25DAD7AB8 (files_categories_id), INDEX IDX_A9CAFAE2A3E65B2F (files_id), PRIMARY KEY(files_categories_id, files_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540599D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE files_chats ADD CONSTRAINT FK_175A81C4A3E65B2F FOREIGN KEY (files_id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_chats ADD CONSTRAINT FK_175A81C4AC6FF313 FOREIGN KEY (chats_id) REFERENCES chats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_calendars ADD CONSTRAINT FK_FC2DE5B4A3E65B2F FOREIGN KEY (files_id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_calendars ADD CONSTRAINT FK_FC2DE5B472C4B705 FOREIGN KEY (calendars_id) REFERENCES calendars (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_messages ADD CONSTRAINT FK_2EAC07DEA3E65B2F FOREIGN KEY (files_id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_messages ADD CONSTRAINT FK_2EAC07DEA5905F5A FOREIGN KEY (messages_id) REFERENCES messages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_categories_files ADD CONSTRAINT FK_A9CAFAE25DAD7AB8 FOREIGN KEY (files_categories_id) REFERENCES files_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files_categories_files ADD CONSTRAINT FK_A9CAFAE2A3E65B2F FOREIGN KEY (files_id) REFERENCES files (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_63540599D86650F');
        $this->addSql('ALTER TABLE files_chats DROP FOREIGN KEY FK_175A81C4A3E65B2F');
        $this->addSql('ALTER TABLE files_chats DROP FOREIGN KEY FK_175A81C4AC6FF313');
        $this->addSql('ALTER TABLE files_calendars DROP FOREIGN KEY FK_FC2DE5B4A3E65B2F');
        $this->addSql('ALTER TABLE files_calendars DROP FOREIGN KEY FK_FC2DE5B472C4B705');
        $this->addSql('ALTER TABLE files_messages DROP FOREIGN KEY FK_2EAC07DEA3E65B2F');
        $this->addSql('ALTER TABLE files_messages DROP FOREIGN KEY FK_2EAC07DEA5905F5A');
        $this->addSql('ALTER TABLE files_categories_files DROP FOREIGN KEY FK_A9CAFAE25DAD7AB8');
        $this->addSql('ALTER TABLE files_categories_files DROP FOREIGN KEY FK_A9CAFAE2A3E65B2F');
        $this->addSql('DROP TABLE calendars');
        $this->addSql('DROP TABLE chats');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE files_chats');
        $this->addSql('DROP TABLE files_calendars');
        $this->addSql('DROP TABLE files_messages');
        $this->addSql('DROP TABLE files_categories');
        $this->addSql('DROP TABLE files_categories_files');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
