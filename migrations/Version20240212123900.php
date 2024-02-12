<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212123900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, job_title VARCHAR(255) NOT NULL, job_description VARCHAR(5000) NOT NULL, job_location VARCHAR(255) NOT NULL, job_requirement VARCHAR(255) NOT NULL, job_category VARCHAR(255) NOT NULL, createdate DATETIME NOT NULL, INDEX IDX_DD461ACCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_post ADD CONSTRAINT FK_DD461ACCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_post DROP FOREIGN KEY FK_DD461ACCA76ED395');
        $this->addSql('DROP TABLE job_post');
    }
}
