<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221209180606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade ADD strategy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A4366D5CAD932 FOREIGN KEY (strategy_id) REFERENCES strategy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7E1A4366D5CAD932 ON trade (strategy_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trade DROP CONSTRAINT FK_7E1A4366D5CAD932');
        $this->addSql('DROP INDEX IDX_7E1A4366D5CAD932');
        $this->addSql('ALTER TABLE trade DROP strategy_id');
    }
}
