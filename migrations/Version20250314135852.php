<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314135852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD roles JSON');
        $this->addSql('UPDATE "user" SET "roles" = \'["ROLE_USER"]\'');
        $this->addSql('ALTER TABLE "user" ALTER roles SET NOT NULL');

        $this->addSql('ALTER TABLE "user" ADD password VARCHAR(255)');
        $this->addSql('UPDATE "user" SET "password" = \'123456789\'');
        $this->addSql('ALTER TABLE "user" ALTER password SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" DROP password');
    }
}
