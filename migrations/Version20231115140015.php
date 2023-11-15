<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115140015 extends AbstractMigration
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
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, lieu_activite_of_user_id INT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, departement VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, INDEX IDX_BFD3CE8F85D1655C (lieu_activite_of_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passage_certification (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', stagiaire_id INT NOT NULL, certification_id INT NOT NULL, obtention_certification VARCHAR(255) DEFAULT \'PAR_SCORING\' NOT NULL, donnee_certifiee TINYINT(1) DEFAULT 1 NOT NULL, date_debut_validite DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_fin_validite DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', presence_niveau_langue_euro TINYINT(1) DEFAULT 0 NOT NULL, presence_niveau_numerique_euro TINYINT(1) DEFAULT 0 NOT NULL, scoring VARCHAR(255) DEFAULT NULL, mention_validee VARCHAR(255) DEFAULT NULL, INDEX IDX_88495CEBBBA93DD6 (stagiaire_id), INDEX IDX_88495CEBCB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presence_web (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_E2E77E94A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, centre_formation_id INT NOT NULL, certification_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_C11D7DD189FEAA37 (centre_formation_id), INDEX IDX_C11D7DD1CB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, sexe VARCHAR(1) NOT NULL, code_postal_naissance VARCHAR(255) DEFAULT NULL, id_dossier_cpf VARCHAR(255) DEFAULT NULL, identifiants_financeurs LONGTEXT DEFAULT NULL, en_formation TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_4F62F731A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire_promotion (stagiaire_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_D9AA39CFBBA93DD6 (stagiaire_id), INDEX IDX_D9AA39CF139DF194 (promotion_id), PRIMARY KEY(stagiaire_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, adresse_postale_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom_naissance VARCHAR(255) NOT NULL, nom_usage VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) NOT NULL, nom_structure VARCHAR(255) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', phone_number VARCHAR(255) DEFAULT NULL, visio TINYINT(1) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649C96EEC07 (adresse_postale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centre_formation ADD CONSTRAINT FK_B7248836C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8F85D1655C FOREIGN KEY (lieu_activite_of_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE presence_web ADD CONSTRAINT FK_E2E77E94A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD189FEAA37 FOREIGN KEY (centre_formation_id) REFERENCES centre_formation (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1CB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stagiaire_promotion ADD CONSTRAINT FK_D9AA39CFBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stagiaire_promotion ADD CONSTRAINT FK_D9AA39CF139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C96EEC07 FOREIGN KEY (adresse_postale_id) REFERENCES localisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre_formation DROP FOREIGN KEY FK_B7248836C68BE09C');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8F85D1655C');
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBBBA93DD6');
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBCB47068A');
        $this->addSql('ALTER TABLE presence_web DROP FOREIGN KEY FK_E2E77E94A76ED395');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD189FEAA37');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1CB47068A');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731A76ED395');
        $this->addSql('ALTER TABLE stagiaire_promotion DROP FOREIGN KEY FK_D9AA39CFBBA93DD6');
        $this->addSql('ALTER TABLE stagiaire_promotion DROP FOREIGN KEY FK_D9AA39CF139DF194');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C96EEC07');
        $this->addSql('DROP TABLE centre_formation');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE passage_certification');
        $this->addSql('DROP TABLE presence_web');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE stagiaire_promotion');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
