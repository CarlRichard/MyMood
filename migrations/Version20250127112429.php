<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127112429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerte ADD date_creation DATETIME NOT NULL, ADD user_id INT NOT NULL, DROP date_envoi, CHANGE statut statut VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE blacklist ADD superviseur_id INT NOT NULL, DROP est_blacklist, CHANGE utilisateur_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE blacklist ADD CONSTRAINT FK_3B175385B7BB80FF FOREIGN KEY (superviseur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_3B175385B7BB80FF ON blacklist (superviseur_id)');
        $this->addSql('ALTER TABLE historique ADD utilisateur_id INT NOT NULL, ADD date_creation DATETIME NOT NULL, ADD action VARCHAR(255) DEFAULT NULL, ADD date_action DATETIME DEFAULT NULL, DROP date_envoi, CHANGE humeur humeur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECFB88E14F ON historique (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32C9BA629');
        $this->addSql('DROP INDEX IDX_1D1C63B32C9BA629 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, DROP alerte_id, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE utilisateur RENAME INDEX uniq_identifier_email TO UNIQ_1D1C63B3E7927C74');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD alerte_id INT DEFAULT NULL, DROP nom, DROP prenom, CHANGE roles roles VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32C9BA629 FOREIGN KEY (alerte_id) REFERENCES alerte (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1D1C63B32C9BA629 ON utilisateur (alerte_id)');
        $this->addSql('ALTER TABLE utilisateur RENAME INDEX uniq_1d1c63b3e7927c74 TO UNIQ_IDENTIFIER_EMAIL');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECFB88E14F');
        $this->addSql('DROP INDEX IDX_EDBFD5ECFB88E14F ON historique');
        $this->addSql('ALTER TABLE historique ADD date_envoi VARCHAR(255) NOT NULL, DROP utilisateur_id, DROP date_creation, DROP action, DROP date_action, CHANGE humeur humeur INT NOT NULL');
        $this->addSql('ALTER TABLE alerte ADD date_envoi DATE NOT NULL, DROP date_creation, DROP user_id, CHANGE statut statut INT NOT NULL');
        $this->addSql('ALTER TABLE blacklist DROP FOREIGN KEY FK_3B175385B7BB80FF');
        $this->addSql('DROP INDEX IDX_3B175385B7BB80FF ON blacklist');
        $this->addSql('ALTER TABLE blacklist ADD est_blacklist TINYINT(1) NOT NULL, DROP superviseur_id, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
    }
}
