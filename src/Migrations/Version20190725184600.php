<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190725184600 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billing_bagel (billing_id INT NOT NULL, bagel_id INT NOT NULL, INDEX IDX_B223094F3B025C87 (billing_id), INDEX IDX_B223094F76FEACB8 (bagel_id), PRIMARY KEY(billing_id, bagel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing_panini (billing_id INT NOT NULL, panini_id INT NOT NULL, INDEX IDX_8873E853B025C87 (billing_id), INDEX IDX_8873E857B573F3 (panini_id), PRIMARY KEY(billing_id, panini_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billing_bagel ADD CONSTRAINT FK_B223094F3B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing_bagel ADD CONSTRAINT FK_B223094F76FEACB8 FOREIGN KEY (bagel_id) REFERENCES bagel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing_panini ADD CONSTRAINT FK_8873E853B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE billing_panini ADD CONSTRAINT FK_8873E857B573F3 FOREIGN KEY (panini_id) REFERENCES panini (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE billing_bagel');
        $this->addSql('DROP TABLE billing_panini');
    }
}
