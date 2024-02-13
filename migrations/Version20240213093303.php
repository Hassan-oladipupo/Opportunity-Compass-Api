<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213093303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_form ADD applicant_id INT NOT NULL, ADD related_job_post_id INT NOT NULL');
        $this->addSql('ALTER TABLE application_form ADD CONSTRAINT FK_A56495C797139001 FOREIGN KEY (applicant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE application_form ADD CONSTRAINT FK_A56495C71A8DCA33 FOREIGN KEY (related_job_post_id) REFERENCES job_post (id)');
        $this->addSql('CREATE INDEX IDX_A56495C797139001 ON application_form (applicant_id)');
        $this->addSql('CREATE INDEX IDX_A56495C71A8DCA33 ON application_form (related_job_post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_form DROP FOREIGN KEY FK_A56495C797139001');
        $this->addSql('ALTER TABLE application_form DROP FOREIGN KEY FK_A56495C71A8DCA33');
        $this->addSql('DROP INDEX IDX_A56495C797139001 ON application_form');
        $this->addSql('DROP INDEX IDX_A56495C71A8DCA33 ON application_form');
        $this->addSql('ALTER TABLE application_form DROP applicant_id, DROP related_job_post_id');
    }
}
