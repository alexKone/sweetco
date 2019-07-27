<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190721095911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, payment_method VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, total_price DOUBLE PRECISION NOT NULL, billing_address LONGTEXT NOT NULL, billing_city VARCHAR(255) NOT NULL, billing_zipcode VARCHAR(255) DEFAULT NULL, delivery_method VARCHAR(255) DEFAULT NULL, pickup_hour VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing_formule (billing_id INT NOT NULL, formule_id INT NOT NULL, INDEX IDX_B72174F3B025C87 (billing_id), INDEX IDX_B72174F2A68F4D1 (formule_id), PRIMARY KEY(billing_id, formule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billing_formule ADD CONSTRAINT FK_B72174F3B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing_formule ADD CONSTRAINT FK_B72174F2A68F4D1 FOREIGN KEY (formule_id) REFERENCES formule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salade ADD billing_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salade ADD CONSTRAINT FK_9C8A52E93B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('CREATE INDEX IDX_9C8A52E93B025C87 ON salade (billing_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billing_formule DROP FOREIGN KEY FK_B72174F3B025C87');
        $this->addSql('ALTER TABLE salade DROP FOREIGN KEY FK_9C8A52E93B025C87');
        $this->addSql('DROP TABLE billing');
        $this->addSql('DROP TABLE billing_formule');
        $this->addSql('DROP INDEX IDX_9C8A52E93B025C87 ON salade');
        $this->addSql('ALTER TABLE salade DROP billing_id');
    }
}
