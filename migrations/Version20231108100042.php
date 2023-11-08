<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108100042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, code VARCHAR(100) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passage_certification (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', stagiaire_id INT NOT NULL, certification_id INT NOT NULL, obtention_certification VARCHAR(255) DEFAULT \'PAR_ADMISSION\' NOT NULL, donnee_certifiee TINYINT(1) NOT NULL, date_debut_validite DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_fin_validite DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', presence_niveau_langue_euro TINYINT(1) DEFAULT 0 NOT NULL, presence_niveau_numerique_euro TINYINT(1) DEFAULT 0 NOT NULL, scoring VARCHAR(255) DEFAULT NULL, mention_validee VARCHAR(255) DEFAULT NULL, INDEX IDX_88495CEBBBA93DD6 (stagiaire_id), INDEX IDX_88495CEBCB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, nom_naissance VARCHAR(60) NOT NULL, nom_usage VARCHAR(60) DEFAULT NULL, prenom VARCHAR(60) NOT NULL, prenom2 VARCHAR(60) DEFAULT NULL, prenom3 VARCHAR(60) DEFAULT NULL, date_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', sexe VARCHAR(1) NOT NULL, code_postal_naissance INT DEFAULT NULL, id_dossier_cpf VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, reseaux JSON DEFAULT NULL, localisation JSON DEFAULT NULL, visio TINYINT(1) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBBBA93DD6');
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBCB47068A');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE passage_certification');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
