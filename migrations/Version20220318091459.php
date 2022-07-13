<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318091459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom_contact VARCHAR(255) NOT NULL, email_contact VARCHAR(255) NOT NULL, message_contact LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_project (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, lien_projet VARCHAR(255) NOT NULL, INDEX IDX_BAA38732C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, nom_projet VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, descrip_projet LONGTEXT NOT NULL, documentation VARCHAR(255) DEFAULT NULL, vignette_projet VARCHAR(255) NOT NULL, lien_projet VARCHAR(255) NOT NULL, technologie LONGTEXT NOT NULL, cahier_des_charges VARCHAR(255) NOT NULL, veille LONGTEXT NOT NULL, participant VARCHAR(255) NOT NULL, outil LONGTEXT DEFAULT NULL, mission_realise LONGTEXT DEFAULT NULL, contexte LONGTEXT NOT NULL, encadrant VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_project ADD CONSTRAINT FK_BAA38732C18272 FOREIGN KEY (projet_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_project DROP FOREIGN KEY FK_BAA38732C18272');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE image_project');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
