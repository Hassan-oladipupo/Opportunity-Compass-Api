<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219074507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE saved_job (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, job_post_id INT NOT NULL, INDEX IDX_1FA2C7F0A76ED395 (user_id), INDEX IDX_1FA2C7F0D166B4B7 (job_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE saved_job ADD CONSTRAINT FK_1FA2C7F0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE saved_job ADD CONSTRAINT FK_1FA2C7F0D166B4B7 FOREIGN KEY (job_post_id) REFERENCES job_post (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE saved_job DROP FOREIGN KEY FK_1FA2C7F0A76ED395');
        $this->addSql('ALTER TABLE saved_job DROP FOREIGN KEY FK_1FA2C7F0D166B4B7');
        $this->addSql('DROP TABLE saved_job');
    }
}
