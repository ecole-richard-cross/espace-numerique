<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116092142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE block (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, media_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, number INT NOT NULL, INDEX IDX_831B9722D823E37A (section_id), INDEX IDX_831B9722EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, seminar_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, number INT NOT NULL, INDEX IDX_F981B52E735A6AB8 (seminar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, discussion_id INT NOT NULL, replying_to_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C1ADED311 (discussion_id), INDEX IDX_9474526CCDC1BC7C (replying_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C0B9F90FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion_category (discussion_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B31488D61ADED311 (discussion_id), INDEX IDX_B31488D612469DE2 (category_id), PRIMARY KEY(discussion_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion_tag (discussion_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_2F721311ADED311 (discussion_id), INDEX IDX_2F72131BAD26311 (tag_id), PRIMARY KEY(discussion_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, uploaded_by_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6A2CA10CA2B28FE8 (uploaded_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, chapter_id INT NOT NULL, title VARCHAR(255) NOT NULL, number INT NOT NULL, INDEX IDX_2D737AEF579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seminar (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_published TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BFFD2C883DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seminar_category (seminar_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B5ED7356735A6AB8 (seminar_id), INDEX IDX_B5ED735612469DE2 (category_id), PRIMARY KEY(seminar_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seminar_tag (seminar_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_AD94BEC4735A6AB8 (seminar_id), INDEX IDX_AD94BEC4BAD26311 (tag_id), PRIMARY KEY(seminar_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seminar_consultation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, seminar_id INT NOT NULL, is_to_read TINYINT(1) NOT NULL, is_finished TINYINT(1) NOT NULL, last_consulted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_16E57DD3A76ED395 (user_id), INDEX IDX_16E57DD3735A6AB8 (seminar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B9722D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B9722EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E735A6AB8 FOREIGN KEY (seminar_id) REFERENCES seminar (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CCDC1BC7C FOREIGN KEY (replying_to_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discussion_category ADD CONSTRAINT FK_B31488D61ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discussion_category ADD CONSTRAINT FK_B31488D612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discussion_tag ADD CONSTRAINT FK_2F721311ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discussion_tag ADD CONSTRAINT FK_2F72131BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE seminar ADD CONSTRAINT FK_BFFD2C883DA5256D FOREIGN KEY (image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE seminar_category ADD CONSTRAINT FK_B5ED7356735A6AB8 FOREIGN KEY (seminar_id) REFERENCES seminar (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seminar_category ADD CONSTRAINT FK_B5ED735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seminar_tag ADD CONSTRAINT FK_AD94BEC4735A6AB8 FOREIGN KEY (seminar_id) REFERENCES seminar (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seminar_tag ADD CONSTRAINT FK_AD94BEC4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seminar_consultation ADD CONSTRAINT FK_16E57DD3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE seminar_consultation ADD CONSTRAINT FK_16E57DD3735A6AB8 FOREIGN KEY (seminar_id) REFERENCES seminar (id)');
        $this->addSql('ALTER TABLE user ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64986383B10 ON user (avatar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE block DROP FOREIGN KEY FK_831B9722D823E37A');
        $this->addSql('ALTER TABLE block DROP FOREIGN KEY FK_831B9722EA9FDD75');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E735A6AB8');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1ADED311');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CCDC1BC7C');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FA76ED395');
        $this->addSql('ALTER TABLE discussion_category DROP FOREIGN KEY FK_B31488D61ADED311');
        $this->addSql('ALTER TABLE discussion_category DROP FOREIGN KEY FK_B31488D612469DE2');
        $this->addSql('ALTER TABLE discussion_tag DROP FOREIGN KEY FK_2F721311ADED311');
        $this->addSql('ALTER TABLE discussion_tag DROP FOREIGN KEY FK_2F72131BAD26311');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA2B28FE8');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF579F4768');
        $this->addSql('ALTER TABLE seminar DROP FOREIGN KEY FK_BFFD2C883DA5256D');
        $this->addSql('ALTER TABLE seminar_category DROP FOREIGN KEY FK_B5ED7356735A6AB8');
        $this->addSql('ALTER TABLE seminar_category DROP FOREIGN KEY FK_B5ED735612469DE2');
        $this->addSql('ALTER TABLE seminar_tag DROP FOREIGN KEY FK_AD94BEC4735A6AB8');
        $this->addSql('ALTER TABLE seminar_tag DROP FOREIGN KEY FK_AD94BEC4BAD26311');
        $this->addSql('ALTER TABLE seminar_consultation DROP FOREIGN KEY FK_16E57DD3A76ED395');
        $this->addSql('ALTER TABLE seminar_consultation DROP FOREIGN KEY FK_16E57DD3735A6AB8');
        $this->addSql('DROP TABLE block');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE discussion_category');
        $this->addSql('DROP TABLE discussion_tag');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE seminar');
        $this->addSql('DROP TABLE seminar_category');
        $this->addSql('DROP TABLE seminar_tag');
        $this->addSql('DROP TABLE seminar_consultation');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP INDEX IDX_8D93D64986383B10 ON user');
        $this->addSql('ALTER TABLE user DROP avatar_id');
    }
}
