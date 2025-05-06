<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240903231622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F819D86650F');
        $this->addSql('DROP INDEX IDX_D4E6F819D86650F ON address');
        $this->addSql('ALTER TABLE address DROP user_id_id');
        $this->addSql('ALTER TABLE `order` DROP user_id_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD37AC84E');
        $this->addSql('DROP INDEX IDX_D34A04AD37AC84E ON product');
        $this->addSql('ALTER TABLE product DROP store_id_id, CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE store ADD email VARCHAR(255) DEFAULT NULL, ADD photo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F819D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D4E6F819D86650F ON address (user_id_id)');
        $this->addSql('ALTER TABLE store DROP email, DROP photo');
        $this->addSql('ALTER TABLE product ADD store_id_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD37AC84E FOREIGN KEY (store_id_id) REFERENCES store (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD37AC84E ON product (store_id_id)');
        $this->addSql('ALTER TABLE `order` ADD user_id_id INT NOT NULL');
    }
}
