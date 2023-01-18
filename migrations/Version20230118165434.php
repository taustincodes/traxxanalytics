<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118165434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE strategy ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE strategy DROP "user"');
        $this->addSql('ALTER TABLE strategy ADD CONSTRAINT FK_144645EDA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_144645EDA76ED395 ON strategy (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE strategy DROP CONSTRAINT FK_144645EDA76ED395');
        $this->addSql('DROP INDEX IDX_144645EDA76ED395');
        $this->addSql('ALTER TABLE strategy ADD "user" INT NOT NULL');
        $this->addSql('ALTER TABLE strategy DROP user_id');
    }
}
