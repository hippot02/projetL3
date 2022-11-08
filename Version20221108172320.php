<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108172320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accueil (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) DEFAULT NULL, total_files_on_site INT NOT NULL, text_on_home VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, id_contact INT NOT NULL, userid INT NOT NULL, message VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_user (contact_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A56C54B6E7A1254A (contact_id), INDEX IDX_A56C54B6A76ED395 (user_id), PRIMARY KEY(contact_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE upload (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, files VARCHAR(255) NOT NULL, count_download INT NOT NULL, file_password VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE upload_user (upload_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9175130CCCFBA31 (upload_id), INDEX IDX_9175130A76ED395 (user_id), PRIMARY KEY(upload_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, upload_id INT DEFAULT NULL, contact_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649CCCFBA31 (upload_id), INDEX IDX_8D93D649E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_user ADD CONSTRAINT FK_A56C54B6E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_user ADD CONSTRAINT FK_A56C54B6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE upload_user ADD CONSTRAINT FK_9175130CCCFBA31 FOREIGN KEY (upload_id) REFERENCES upload (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE upload_user ADD CONSTRAINT FK_9175130A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCCFBA31 FOREIGN KEY (upload_id) REFERENCES upload (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_user DROP FOREIGN KEY FK_A56C54B6E7A1254A');
        $this->addSql('ALTER TABLE contact_user DROP FOREIGN KEY FK_A56C54B6A76ED395');
        $this->addSql('ALTER TABLE upload_user DROP FOREIGN KEY FK_9175130CCCFBA31');
        $this->addSql('ALTER TABLE upload_user DROP FOREIGN KEY FK_9175130A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCCFBA31');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E7A1254A');
        $this->addSql('DROP TABLE accueil');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_user');
        $this->addSql('DROP TABLE upload');
        $this->addSql('DROP TABLE upload_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
