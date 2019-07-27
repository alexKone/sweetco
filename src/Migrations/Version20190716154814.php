<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190716154814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bagel ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE boisson ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE dessert ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE formule ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE ingredient ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE panini ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE sauce ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bagel DROP is_active');
        $this->addSql('ALTER TABLE boisson DROP is_active');
        $this->addSql('ALTER TABLE dessert DROP is_active');
        $this->addSql('ALTER TABLE formule DROP is_active');
        $this->addSql('ALTER TABLE ingredient DROP is_active');
        $this->addSql('ALTER TABLE panini DROP is_active');
        $this->addSql('ALTER TABLE sauce DROP is_active');
    }
}
