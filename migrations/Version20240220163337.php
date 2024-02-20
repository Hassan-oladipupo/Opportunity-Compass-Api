<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220163337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_profile ADD job_post_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405D166B4B7 FOREIGN KEY (job_post_id) REFERENCES job_post (id)');
        $this->addSql('CREATE INDEX IDX_D95AB405D166B4B7 ON user_profile (job_post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB405D166B4B7');
        $this->addSql('DROP INDEX IDX_D95AB405D166B4B7 ON user_profile');
        $this->addSql('ALTER TABLE user_profile DROP job_post_id');
    }
}
