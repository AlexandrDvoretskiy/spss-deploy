<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312215219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP CONSTRAINT fk__mark__task_id');
        $this->addSql('DROP INDEX skill__task_id__ind');
        $this->addSql('ALTER TABLE skill DROP task_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill ADD task_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT fk__mark__task_id FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX skill__task_id__ind ON skill (task_id)');
    }
}
