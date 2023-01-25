<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125171040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog CHANGE imghoritzontal2 imghoritzontal2 VARCHAR(255) DEFAULT NULL, CHANGE imgvertical1 imgvertical1 VARCHAR(255) DEFAULT NULL, CHANGE content1 content1 TEXT DEFAULT NULL, CHANGE content2 content2 TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog CHANGE imghoritzontal2 imghoritzontal2 VARCHAR(255) NOT NULL, CHANGE imgvertical1 imgvertical1 VARCHAR(255) NOT NULL, CHANGE content1 content1 TEXT NOT NULL, CHANGE content2 content2 TEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL');
    }
}
