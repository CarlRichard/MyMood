<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121210415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cohorte (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_fin DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_cohorte (utilisateur_id INT NOT NULL, cohorte_id INT NOT NULL, INDEX IDX_4F628DD9FB88E14F (utilisateur_id), INDEX IDX_4F628DD9FB30EFA4 (cohorte_id), PRIMARY KEY(utilisateur_id, cohorte_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_cohorte ADD CONSTRAINT FK_4F628DD9FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_cohorte ADD CONSTRAINT FK_4F628DD9FB30EFA4 FOREIGN KEY (cohorte_id) REFERENCES cohorte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blacklist ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blacklist ADD CONSTRAINT FK_3B175385FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_3B175385FB88E14F ON blacklist (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur ADD alerte_id INT DEFAULT NULL, CHANGE roles roles VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32C9BA629 FOREIGN KEY (alerte_id) REFERENCES alerte (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B32C9BA629 ON utilisateur (alerte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_cohorte DROP FOREIGN KEY FK_4F628DD9FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_cohorte DROP FOREIGN KEY FK_4F628DD9FB30EFA4');
        $this->addSql('DROP TABLE cohorte');
        $this->addSql('DROP TABLE utilisateur_cohorte');
        $this->addSql('ALTER TABLE blacklist DROP FOREIGN KEY FK_3B175385FB88E14F');
        $this->addSql('DROP INDEX IDX_3B175385FB88E14F ON blacklist');
        $this->addSql('ALTER TABLE blacklist DROP utilisateur_id');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32C9BA629');
        $this->addSql('DROP INDEX IDX_1D1C63B32C9BA629 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP alerte_id, CHANGE roles roles JSON NOT NULL');
    }
}
