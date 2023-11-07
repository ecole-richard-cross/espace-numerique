<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231107142654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEB2AA7DFFB');
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEB34012818');
        $this->addSql('DROP INDEX IDX_88495CEB2AA7DFFB ON passage_certification');
        $this->addSql('DROP INDEX IDX_88495CEB34012818 ON passage_certification');
        $this->addSql('ALTER TABLE passage_certification ADD stagiaire_id INT NOT NULL, ADD certification_id INT NOT NULL, DROP stagiaire_id_id, DROP certification_id_id');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEBCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('CREATE INDEX IDX_88495CEBBBA93DD6 ON passage_certification (stagiaire_id)');
        $this->addSql('CREATE INDEX IDX_88495CEBCB47068A ON passage_certification (certification_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBBBA93DD6');
        $this->addSql('ALTER TABLE passage_certification DROP FOREIGN KEY FK_88495CEBCB47068A');
        $this->addSql('DROP INDEX IDX_88495CEBBBA93DD6 ON passage_certification');
        $this->addSql('DROP INDEX IDX_88495CEBCB47068A ON passage_certification');
        $this->addSql('ALTER TABLE passage_certification ADD stagiaire_id_id INT NOT NULL, ADD certification_id_id INT NOT NULL, DROP stagiaire_id, DROP certification_id');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEB2AA7DFFB FOREIGN KEY (stagiaire_id_id) REFERENCES stagiaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE passage_certification ADD CONSTRAINT FK_88495CEB34012818 FOREIGN KEY (certification_id_id) REFERENCES certification (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_88495CEB2AA7DFFB ON passage_certification (stagiaire_id_id)');
        $this->addSql('CREATE INDEX IDX_88495CEB34012818 ON passage_certification (certification_id_id)');
    }
}
