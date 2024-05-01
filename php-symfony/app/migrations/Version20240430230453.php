<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430230453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento ADD terreno VARCHAR(50) NOT NULL, ADD tipo VARCHAR(50) NOT NULL, DROP tipo_terreno, DROP tipo_evento');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento ADD tipo_terreno VARCHAR(50) NOT NULL, ADD tipo_evento VARCHAR(50) NOT NULL, DROP terreno, DROP tipo');
    }
}
