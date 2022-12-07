<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207165505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE strategy_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE strategy (id INT NOT NULL, name VARCHAR(255) NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE trade ALTER leverage SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE strategy_id_seq CASCADE');
        $this->addSql('DROP TABLE strategy');
        $this->addSql('ALTER TABLE trade ALTER leverage DROP NOT NULL');
    }
}
