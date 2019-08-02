<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190730120120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bread (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bread_salade (bread_id INT NOT NULL, salade_id INT NOT NULL, INDEX IDX_C950414C5D3405CF (bread_id), INDEX IDX_C950414C45927B6B (salade_id), PRIMARY KEY(bread_id, salade_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bread_salade ADD CONSTRAINT FK_C950414C5D3405CF FOREIGN KEY (bread_id) REFERENCES bread (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bread_salade ADD CONSTRAINT FK_C950414C45927B6B FOREIGN KEY (salade_id) REFERENCES salade (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bread_salade DROP FOREIGN KEY FK_C950414C5D3405CF');
        $this->addSql('DROP TABLE bread');
        $this->addSql('DROP TABLE bread_salade');
    }
}
