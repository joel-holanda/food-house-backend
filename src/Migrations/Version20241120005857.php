<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120005857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD5887B07F FOREIGN KEY (type_product_id) REFERENCES type_product (id)');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877F5B7AF75');
        $this->addSql('DROP INDEX UNIQ_FF575877F5B7AF75 ON store');
        $this->addSql('ALTER TABLE store ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP address_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD5887B07F');
        $this->addSql('ALTER TABLE store ADD address_id INT DEFAULT NULL, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF575877F5B7AF75 ON store (address_id)');
    }
}
