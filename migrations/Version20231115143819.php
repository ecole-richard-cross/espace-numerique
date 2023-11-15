<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115143819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8F85D1655C');
        $this->addSql('DROP INDEX IDX_BFD3CE8F85D1655C ON localisation');
        $this->addSql('ALTER TABLE localisation CHANGE lieu_activite_of_user_id lieux_activite_of_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FFA8A7045 FOREIGN KEY (lieux_activite_of_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BFD3CE8FFA8A7045 ON localisation (lieux_activite_of_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FFA8A7045');
        $this->addSql('DROP INDEX IDX_BFD3CE8FFA8A7045 ON localisation');
        $this->addSql('ALTER TABLE localisation CHANGE lieux_activite_of_user_id lieu_activite_of_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8F85D1655C FOREIGN KEY (lieu_activite_of_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BFD3CE8F85D1655C ON localisation (lieu_activite_of_user_id)');
    }
}
