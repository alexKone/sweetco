<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802162713 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formule_container (id INT AUTO_INCREMENT NOT NULL, formule_id INT DEFAULT NULL, salade_id INT DEFAULT NULL, bagel_id INT DEFAULT NULL, panini_id INT DEFAULT NULL, boisson_id INT DEFAULT NULL, INDEX IDX_FDDC9E5D2A68F4D1 (formule_id), UNIQUE INDEX UNIQ_FDDC9E5D45927B6B (salade_id), INDEX IDX_FDDC9E5D76FEACB8 (bagel_id), INDEX IDX_FDDC9E5D7B573F3 (panini_id), INDEX IDX_FDDC9E5D734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formule_container ADD CONSTRAINT FK_FDDC9E5D2A68F4D1 FOREIGN KEY (formule_id) REFERENCES formule (id)');
        $this->addSql('ALTER TABLE formule_container ADD CONSTRAINT FK_FDDC9E5D45927B6B FOREIGN KEY (salade_id) REFERENCES salade (id)');
        $this->addSql('ALTER TABLE formule_container ADD CONSTRAINT FK_FDDC9E5D76FEACB8 FOREIGN KEY (bagel_id) REFERENCES bagel (id)');
        $this->addSql('ALTER TABLE formule_container ADD CONSTRAINT FK_FDDC9E5D7B573F3 FOREIGN KEY (panini_id) REFERENCES panini (id)');
        $this->addSql('ALTER TABLE formule_container ADD CONSTRAINT FK_FDDC9E5D734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formule_container');
    }
}
