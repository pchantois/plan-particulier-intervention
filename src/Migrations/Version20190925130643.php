<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190925130643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE operation_data (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, montant INT NOT NULL, annee VARCHAR(4) NOT NULL, type TINYINT(1) NOT NULL, INDEX IDX_8283AEF244AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operation_data ADD CONSTRAINT FK_8283AEF244AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE operation ADD recueil TINYINT(1) NOT NULL, DROP montant, DROP annee, CHANGE type dob TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE operation_data');
        $this->addSql('ALTER TABLE operation ADD montant INT DEFAULT NULL, ADD annee VARCHAR(4) NOT NULL COLLATE utf8mb4_unicode_ci, ADD type TINYINT(1) NOT NULL, DROP dob, DROP recueil');
    }
}
