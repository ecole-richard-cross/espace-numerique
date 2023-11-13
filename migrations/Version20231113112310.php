<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113112310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre_formation (id INT AUTO_INCREMENT NOT NULL, localisation_id INT NOT NULL, name VARCHAR(255) NOT NULL, debut_activite DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', fin_activite DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_B7248836C68BE09C (localisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, code VARCHAR(100) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal INT DEFAULT NULL, departement VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passage_certification (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', stagiaire_id INT NOT NULL, certification_id INT NOT NULL, obtention_certification VARCHAR(255) DEFAULT \'PAR_SCORING\' NOT NULL, donnee_certifiee TINYINT(1) DEFAULT 1 NOT NULL, date_debut_validite DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_fin_validite DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', presence_niveau_langue_euro TINYINT(1) DEFAULT 0 NOT NULL, presence_niveau_numerique_euro TINYINT(1) DEFAULT 0 NOT NULL, scoring VARCHAR(255) DEFAULT NULL, mention_validee VARCHAR(255) DEFAULT NULL, INDEX IDX_88495CEBBBA93DD6 (stagiaire_id), INDEX IDX_88495CEBCB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presence_web (id INT AUTO_INCREMENT NOT NULL, stagiaire_id INT NOT NULL, type VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_E2E77E94BBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, centre_formation_id INT NOT NULL, certification_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_C11D7DD189FEAA37 (centre_formation_id), INDEX IDX_C11D7DD1CB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, adresse_postal_id INT DEFAULT NULL, nom_naissance VARCHAR(60) NOT NULL, nom_usage VARCHAR(60) DEFAULT NULL, prenom VARCHAR(60) NOT NULL, date_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', sexe VARCHAR(1) NOT NULL, code_postal_naissance INT DEFAULT NULL, id_dossier_cpf VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(24) DEFAULT NULL, identifiants_financeurs LONGTEXT DEFAULT NULL, visio TINYINT(1) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_4F62F731B3F77CBF (adresse_postal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire_localisation (stagiaire_id INT NOT NULL, localisation_id INT NOT NULL, INDEX IDX_687BECC3BBA93DD6 (stagiaire_id), INDEX IDX_687BECC3C68BE09C (localisation_id), PRIMARY KEY(stagiaire_id, localisation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centre_formation ADD CONSTRAINT FK_B7248836C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE presence_web ADD CONSTRAINT FK_E2E77E94BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD189FEAA37 FOREIGN KEY (centre_formation_id) REFERENCES centre_formation (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1CB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731B3F77CBF FOREIGN KEY (adresse_postal_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE stagiaire_localisation ADD CONSTRAINT FK_687BECC3BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stagiaire_localisation ADD CONSTRAINT FK_687BECC3C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre_formation DROP FOREIGN KEY FK_B7248836C68BE09C');
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBBBA93DD6');
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBCB47068A');
        $this->addSql('ALTER TABLE presence_web DROP FOREIGN KEY FK_E2E77E94BBA93DD6');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD189FEAA37');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1CB47068A');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731B3F77CBF');
        $this->addSql('ALTER TABLE stagiaire_localisation DROP FOREIGN KEY FK_687BECC3BBA93DD6');
        $this->addSql('ALTER TABLE stagiaire_localisation DROP FOREIGN KEY FK_687BECC3C68BE09C');
        $this->addSql('DROP TABLE centre_formation');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE passage_certification');
        $this->addSql('DROP TABLE presence_web');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE stagiaire_localisation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
