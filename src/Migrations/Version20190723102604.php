<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723102604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billing_boisson (billing_id INT NOT NULL, boisson_id INT NOT NULL, INDEX IDX_E0B9439A3B025C87 (billing_id), INDEX IDX_E0B9439A734B8089 (boisson_id), PRIMARY KEY(billing_id, boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing_dessert (billing_id INT NOT NULL, dessert_id INT NOT NULL, INDEX IDX_120790413B025C87 (billing_id), INDEX IDX_12079041745B52FD (dessert_id), PRIMARY KEY(billing_id, dessert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billing_boisson ADD CONSTRAINT FK_E0B9439A3B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing_boisson ADD CONSTRAINT FK_E0B9439A734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing_dessert ADD CONSTRAINT FK_120790413B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing_dessert ADD CONSTRAINT FK_12079041745B52FD FOREIGN KEY (dessert_id) REFERENCES dessert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing ADD addons JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE billing_boisson');
        $this->addSql('DROP TABLE billing_dessert');
        $this->addSql('ALTER TABLE billing DROP addons');
    }
}
