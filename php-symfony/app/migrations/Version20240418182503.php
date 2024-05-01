<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418182503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nick VARCHAR(50) NOT NULL, nombre VARCHAR(50) NOT NULL, apellidos VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, karma VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participantes_eventos (usuario_id INT NOT NULL, evento_id INT NOT NULL, INDEX IDX_E9BDB5F0DB38439E (usuario_id), INDEX IDX_E9BDB5F087A5F842 (evento_id), PRIMARY KEY(usuario_id, evento_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participantes_eventos ADD CONSTRAINT FK_E9BDB5F0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participantes_eventos ADD CONSTRAINT FK_E9BDB5F087A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participantes_eventos DROP FOREIGN KEY FK_E9BDB5F0DB38439E');
        $this->addSql('ALTER TABLE participantes_eventos DROP FOREIGN KEY FK_E9BDB5F087A5F842');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE participantes_eventos');
    }
}
