<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723143820 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE addons (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE addons_base (addons_id INT NOT NULL, base_id INT NOT NULL, INDEX IDX_27190F11B963200D (addons_id), INDEX IDX_27190F116967DF41 (base_id), PRIMARY KEY(addons_id, base_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE addons_ingredient (addons_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_6750BA1B963200D (addons_id), INDEX IDX_6750BA1933FE08C (ingredient_id), PRIMARY KEY(addons_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addons_base ADD CONSTRAINT FK_27190F11B963200D FOREIGN KEY (addons_id) REFERENCES addons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE addons_base ADD CONSTRAINT FK_27190F116967DF41 FOREIGN KEY (base_id) REFERENCES base (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE addons_ingredient ADD CONSTRAINT FK_6750BA1B963200D FOREIGN KEY (addons_id) REFERENCES addons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE addons_ingredient ADD CONSTRAINT FK_6750BA1933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addons_base DROP FOREIGN KEY FK_27190F11B963200D');
        $this->addSql('ALTER TABLE addons_ingredient DROP FOREIGN KEY FK_6750BA1B963200D');
        $this->addSql('DROP TABLE addons');
        $this->addSql('DROP TABLE addons_base');
        $this->addSql('DROP TABLE addons_ingredient');
    }
}
