<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121214405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP utilisateurcol, CHANGE alerte_id alerte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32C9BA629 FOREIGN KEY (alerte_id) REFERENCES alerte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32C9BA629');
        $this->addSql('ALTER TABLE utilisateur ADD utilisateurcol VARCHAR(45) DEFAULT NULL, CHANGE alerte_id alerte_id TINYINT(1) DEFAULT 0');
    }
}
