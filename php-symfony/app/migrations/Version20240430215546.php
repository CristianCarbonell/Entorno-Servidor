<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430215546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento ADD anfitrion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05C334648A FOREIGN KEY (anfitrion_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_47860B05C334648A ON evento (anfitrion_id)');
        $this->addSql('ALTER TABLE usuario CHANGE karma karma VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B05C334648A');
        $this->addSql('DROP INDEX IDX_47860B05C334648A ON evento');
        $this->addSql('ALTER TABLE evento DROP anfitrion_id');
        $this->addSql('ALTER TABLE usuario CHANGE karma karma INT NOT NULL');
    }
}
