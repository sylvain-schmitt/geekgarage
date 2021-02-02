<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201134005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency ADD COLUMN count INTEGER');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__agency AS SELECT id, city, lat, lon, number, mail, address, comment FROM agency');
        $this->addSql('DROP TABLE agency');
        $this->addSql('CREATE TABLE agency (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city VARCHAR(255) NOT NULL, lat NUMERIC(10, 8) NOT NULL, lon NUMERIC(10, 8) NOT NULL, number VARCHAR(100) NOT NULL, mail VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, comment CLOB NOT NULL)');
        $this->addSql('INSERT INTO agency (id, city, lat, lon, number, mail, address, comment) SELECT id, city, lat, lon, number, mail, address, comment FROM __temp__agency');
        $this->addSql('DROP TABLE __temp__agency');
    }
}
