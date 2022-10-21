<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021120624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accueil (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) DEFAULT NULL, total_files_on_site INT NOT NULL, text_on_home VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE upload (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, files VARCHAR(255) NOT NULL, count_download INT NOT NULL, file_password VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE acceuil');
        $this->addSql('ALTER TABLE contact ADD mail_message VARCHAR(255) NOT NULL, ADD username_message VARCHAR(255) NOT NULL, DROP message_id, DROP mail, DROP username');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acceuil (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nb_total_fic INT NOT NULL, texte VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, img_slide VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE accueil');
        $this->addSql('DROP TABLE upload');
        $this->addSql('ALTER TABLE contact ADD message_id INT NOT NULL, ADD mail VARCHAR(255) NOT NULL, ADD username VARCHAR(255) NOT NULL, DROP mail_message, DROP username_message');
    }
}
