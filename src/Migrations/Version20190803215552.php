<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190803215552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formule_container ADD supplement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formule_container ADD CONSTRAINT FK_FDDC9E5D7793FA21 FOREIGN KEY (supplement_id) REFERENCES supplement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDDC9E5D7793FA21 ON formule_container (supplement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formule_container DROP FOREIGN KEY FK_FDDC9E5D7793FA21');
        $this->addSql('DROP INDEX UNIQ_FDDC9E5D7793FA21 ON formule_container');
        $this->addSql('ALTER TABLE formule_container DROP supplement_id');
    }
}
