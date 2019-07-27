<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190713151408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formule DROP FOREIGN KEY FK_605C9C9845927B6B');
        $this->addSql('DROP INDEX UNIQ_605C9C9845927B6B ON formule');
        $this->addSql('ALTER TABLE formule DROP salade_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formule ADD salade_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formule ADD CONSTRAINT FK_605C9C9845927B6B FOREIGN KEY (salade_id) REFERENCES salade (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_605C9C9845927B6B ON formule (salade_id)');
    }
}
