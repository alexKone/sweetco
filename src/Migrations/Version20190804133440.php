<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804133440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formule_container_dessert (formule_container_id INT NOT NULL, dessert_id INT NOT NULL, INDEX IDX_A9ED592562824145 (formule_container_id), INDEX IDX_A9ED5925745B52FD (dessert_id), PRIMARY KEY(formule_container_id, dessert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formule_container_dessert ADD CONSTRAINT FK_A9ED592562824145 FOREIGN KEY (formule_container_id) REFERENCES formule_container (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formule_container_dessert ADD CONSTRAINT FK_A9ED5925745B52FD FOREIGN KEY (dessert_id) REFERENCES dessert (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formule_container_dessert');
    }
}
