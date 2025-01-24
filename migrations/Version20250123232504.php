<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250123232504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alerte (id INT AUTO_INCREMENT NOT NULL, date_envoi DATE NOT NULL, statut INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blacklist (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, est_blacklist TINYINT(1) NOT NULL, INDEX IDX_3B175385FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cohorte (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_fin DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, alerte_id INT DEFAULT NULL, date_envoi VARCHAR(255) NOT NULL, humeur INT NOT NULL, INDEX IDX_EDBFD5EC2C9BA629 (alerte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, alerte_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B32C9BA629 (alerte_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_cohorte (utilisateur_id INT NOT NULL, cohorte_id INT NOT NULL, INDEX IDX_4F628DD9FB88E14F (utilisateur_id), INDEX IDX_4F628DD9FB30EFA4 (cohorte_id), PRIMARY KEY(utilisateur_id, cohorte_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blacklist ADD CONSTRAINT FK_3B175385FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC2C9BA629 FOREIGN KEY (alerte_id) REFERENCES alerte (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32C9BA629 FOREIGN KEY (alerte_id) REFERENCES alerte (id)');
        $this->addSql('ALTER TABLE utilisateur_cohorte ADD CONSTRAINT FK_4F628DD9FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_cohorte ADD CONSTRAINT FK_4F628DD9FB30EFA4 FOREIGN KEY (cohorte_id) REFERENCES cohorte (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blacklist DROP FOREIGN KEY FK_3B175385FB88E14F');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC2C9BA629');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32C9BA629');
        $this->addSql('ALTER TABLE utilisateur_cohorte DROP FOREIGN KEY FK_4F628DD9FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_cohorte DROP FOREIGN KEY FK_4F628DD9FB30EFA4');
        $this->addSql('DROP TABLE alerte');
        $this->addSql('DROP TABLE blacklist');
        $this->addSql('DROP TABLE cohorte');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_cohorte');
    }
}
