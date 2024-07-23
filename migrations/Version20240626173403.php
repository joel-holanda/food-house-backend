<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626173403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food ADD store_id INT DEFAULT NULL, DROP store');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F7B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_D43829F7B092A811 ON food (store_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F7B092A811');
        $this->addSql('DROP INDEX IDX_D43829F7B092A811 ON food');
        $this->addSql('ALTER TABLE food ADD store VARCHAR(255) NOT NULL, DROP store_id');
    }
}
