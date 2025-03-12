<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312230454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_result DROP CONSTRAINT fk__skill_result__task_id');
        $this->addSql('ALTER TABLE skill_result DROP CONSTRAINT fk__skill_result__skill_id');
        $this->addSql('DROP INDEX skill_result__skill_id__ind');
        $this->addSql('DROP INDEX skill_result__task_id__ind');
        $this->addSql('ALTER TABLE skill_result ADD skill_range BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_result DROP task_id');
        $this->addSql('ALTER TABLE skill_result DROP skill_id');
        $this->addSql('ALTER TABLE skill_result ADD CONSTRAINT fk__skill_result__skill_range FOREIGN KEY (skill_range) REFERENCES skill_range (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IF NOT EXISTS skill_result__skill_range__ind ON skill_result (skill_range)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_result DROP CONSTRAINT fk__skill_result__skill_range');
        $this->addSql('DROP INDEX skill_result__skill_range__ind');
        $this->addSql('ALTER TABLE skill_result ADD skill_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_result RENAME COLUMN skill_range TO task_id');
        $this->addSql('ALTER TABLE skill_result ADD CONSTRAINT fk__skill_result__task_id FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_result ADD CONSTRAINT fk__skill_result__skill_id FOREIGN KEY (skill_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IF NOT EXISTS skill_result__skill_id__ind ON skill_result (skill_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS skill_result__task_id__ind ON skill_result (task_id)');
    }
}
